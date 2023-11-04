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
        $order_id = mt_rand(100, 999); // Generates a random 3-digit number (between 100 and 999)

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

                while ($cart_row = mysqli_fetch_assoc($cart_result)) {
                    $product_id = $cart_row['product_id'];
                    $product_name = $cart_row['name'];
                    $product_price = $cart_row['price'];
                    $product_image = $cart_row['image'];
                    $product_quantity = $cart_row['quantity'];
                    $subtotal = $cart_row['subtotal'];
                    $discount = $cart_row['discount'];

                    // Check if a variation exists, and if so, include it in the query
                    $variation = '';
                    if (isset($cart_row['variation'])) {
                        $variation = $cart_row['variation'];
                    }

                    // Insert the order into tb_order
                    $insert_order_query = "INSERT INTO tb_order (order_id, user_id, product_id, name, price, image, qty, variation, order_status, proof_image, order_date, subtotal, discount)
        VALUES ('$order_id', '$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity', '$variation', 'Pending', '$proofFileName', NOW(), '$subtotal', '$discount')";

                    if (mysqli_query($conn, $insert_order_query)) {
                        // Order successfully placed

                        // Update the stock quantity
                        $update_stock_query = "UPDATE tb_product SET qty = qty - '$product_quantity' WHERE product_id = '$product_id'";
                        if (mysqli_query($conn, $update_stock_query)) {
                            // Stock quantity updated successfully

                            // Now, remove the item from tb_cart
                            $delete_cart_item_query = "DELETE FROM tb_cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
                            if (mysqli_query($conn, $delete_cart_item_query)) {
                                // Item removed from the cart
                            } else {
                                // Handle cart item removal failure
                                $error_message = "Error: Unable to remove the item from the cart.";
                            }
                        } else {
                            // Handle stock quantity update failure
                            $error_message = "Error: Unable to update stock quantity.";
                        }
                    } else {
                        // Handle order placement failure
                        $error_message = "Error: Unable to place the order.";
                    }
                }

                // Redirect to the order_customer.php page
                header("Location: order_customer.php");
                exit();

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
