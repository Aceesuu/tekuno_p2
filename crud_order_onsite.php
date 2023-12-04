<?php
include "mysql_connect.php"; // Include your database connection script

if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_qty = $_POST['p_qty'];
    $p_price = $_POST['price'];
    $var_price = $_POST['variation_price'];

    if (is_numeric($var_price)) {
        $subtotal = ($p_qty * $p_price) + $var_price;
    } else {
        // Handle the case where $var_price is not a numeric value (e.g., set $subtotal to a default value)
        $subtotal = $p_qty * $p_price;
    }

    $order_id = mt_rand(100, 999);

    // Retrieve the product ID from the database based on the product name
    $get_product_id_query = "SELECT product_id, qty FROM tb_product WHERE name = ?";
    if ($get_product_id_stmt = mysqli_prepare($conn, $get_product_id_query)) {
        mysqli_stmt_bind_param($get_product_id_stmt, "s", $p_name);
        mysqli_stmt_execute($get_product_id_stmt);
        mysqli_stmt_bind_result($get_product_id_stmt, $product_id, $available_qty);
        mysqli_stmt_fetch($get_product_id_stmt);
        mysqli_stmt_close($get_product_id_stmt);

        if ($available_qty >= $p_qty) {
            // Calculate the remaining quantity after the order
            $remaining_qty = $available_qty - $p_qty;

            // Update the product quantity in the database
            $update_qty_query = "UPDATE tb_product SET qty = ? WHERE product_id = ?";
            if ($update_qty_stmt = mysqli_prepare($conn, $update_qty_query)) {
                mysqli_stmt_bind_param($update_qty_stmt, "ii", $remaining_qty, $product_id);
                if (mysqli_stmt_execute($update_qty_stmt)) {
                    // Insert the order into the "order_onsite" table
                    $insert_order_query = "INSERT INTO order_onsite (order_id, order_date, product_id, name, price, qty, subtotal) VALUES (?, NOW(), ?, ?, ?, ?, ?)";

                    // Prepare the statement
                    if ($stmt = mysqli_prepare($conn, $insert_order_query)) {
                        // Bind parameters
                        mysqli_stmt_bind_param($stmt, "iissid", $order_id, $product_id, $p_name, $p_price, $p_qty, $subtotal);

                        // Execute the statement
                        if (mysqli_stmt_execute($stmt)) {
                            $message[] = 'Order added successfully';
                            header('location: order_onsite.php');
                        } else {
                            $message[] = 'Could not add the product';
                            header('location: order_onsite.php');
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    }
                } else {
                    $message[] = 'Could not update product quantity';
                    header('location: order_onsite.php');
                }
            }
        } else {
            $message[] = 'Insufficient quantity in stock.';
            header('location: order_onsite.php');
        }
    }
}
?>