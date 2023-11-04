<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Start the session

include "mysql_connect.php";
$user_id = $_SESSION['user_id'];

// Query the cart data
$cart_query = "SELECT * FROM tb_cart WHERE user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_query);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["completeOrder"])) {
    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        // Check if a file was uploaded
        if (isset($_FILES['proof_image']) && $_FILES['proof_image']['error'] === UPLOAD_ERR_OK) {
            // Define the target directory where the image will be saved
            $targetDirectory = "proof/";

            // Generate a unique filename for the proof image
            $proofFileName = uniqid() . "_" . basename($_FILES['proof_image']['name']);

            // Define the target path
            $targetPath = $targetDirectory . $proofFileName;

            // Move the uploaded image to the target directory
            if (move_uploaded_file($_FILES['proof_image']['tmp_name'], $targetPath)) {
                // Image uploaded successfully

                // Create a new order
                $order_date = date('Y-m-d'); //date

                // Loop through cart items
                while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                    $product_id = $cart_row['product_id'];
                    $product_name = $cart_row['name'];
                    $product_price = $cart_row['price'];
                    $product_image = $cart_row['image'];
                    $product_quantity = $cart_row['quantity'];

                    // Insert the order for this product
                    $insert_order_query = "INSERT INTO tb_order (user_id, name, price, image, qty, order_status, proof_image, order_date)
        VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity', 'Pending', '$proofFileName', '$order_date')";
                    $insert_query_run = mysqli_query($conn, $insert_order_query);

                    if (!$insert_query_run) {
                        // Handle the error in inserting the order if needed
                        $error_message = "Error: Unable to insert the order.";
                        break; // Exit the loop
                    }
                }

                if ($insert_query_run) {
                    // Retrieve the auto-generated order_id for the last inserted order in 'tb_order'
                    $order_id_tb_order = mysqli_insert_id($conn);

                    // Reset the pointer in the cart result set
                    mysqli_data_seek($cart_result, 0);

                    // Loop through cart items to insert order items
                    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                        $product_name = $cart_row['name'];
                        $product_quantity = $cart_row['quantity'];
                        $subtotal = $cart_row['price'] * $product_quantity;

                        $insert_order_item_query = "INSERT INTO order_items (user_id, order_id, name, qty, subtotal)
            VALUES ('$user_id', '$order_id_tb_order', '$product_name', '$product_quantity', '$subtotal')";

                        $insert_order_item_run = mysqli_query($conn, $insert_order_item_query);

                        if (!$insert_order_item_run) {
                            // Handle the error in inserting order items if needed
                            $error_message = "Error: Unable to insert order items.";
                            break; // Exit the loop
                        }
                    }
                }
            } else {
                // Handle image upload failure
                $error_message = "Error: Unable to upload proof image.";
            }
        } else {
            // Handle the case where no file was uploaded
            $error_message = "Error: No proof image was uploaded.";
        }
    } else {
        // Handle the case where cart data couldn't be retrieved
        $error_message = "Error: Unable to retrieve cart data.";
    }
}
header("Location: order_customer.php");
exit();
