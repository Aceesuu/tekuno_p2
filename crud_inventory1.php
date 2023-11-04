<?php
session_start();
include "mysql_connect.php";

if (isset($_POST['add_product'])) {
    $product_name = $_POST['p_name'];
    $p_sup = $_POST['p_sup'];
    $p_price = $_POST['p_price'];
    $p_qty = $_POST['p_qty'];

    // Retrieve the product ID from the database based on the product name
    $get_product_id_query = "SELECT product_id FROM tb_product WHERE name = ?";
    
    if ($get_product_id_stmt = mysqli_prepare($conn, $get_product_id_query)) {
        mysqli_stmt_bind_param($get_product_id_stmt, "s", $product_name);
        mysqli_stmt_execute($get_product_id_stmt);
        mysqli_stmt_bind_result($get_product_id_stmt, $product_id);
        mysqli_stmt_fetch($get_product_id_stmt);
        mysqli_stmt_close($get_product_id_stmt);

        $insert_stock_query = "INSERT INTO tb_stock (product_id, name, qty, supplier_price, price, date_purchase) VALUES (?, ?, ?, ?, ?, NOW())";

        // Prepare the statement
        if ($stmt = mysqli_prepare($conn, $insert_stock_query)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, "isdss", $product_id, $product_name, $p_qty, $p_sup, $p_price);

            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $message[] = 'Product added to stock successfully';
                header('location: inventory.php');
            } else {
                $message[] = 'Could not add the product to stock';
                header('location: inventory.php');
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_qty = $_POST['update_p_qty'];

    $update_query = mysqli_query($conn, "UPDATE `tb_stock` SET qty = '$update_p_qty' WHERE stock_id = '$update_p_id'");

    // Check if the update was successful
    if ($update_query) {
        // Redirect to manage_product.php after a successful update
        header("Location: inventory.php");
        exit();
    } else {
        // Handle the update failure, e.g., display an error message
        echo "Update failed: " . mysqli_error($conn);
    }
} else {
    header("Location: inventory.php");
    exit();
}
?>