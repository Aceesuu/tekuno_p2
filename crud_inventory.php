<?php
session_start();
include "mysql_connect.php";

if (isset($_POST['add_product'])) {
    // Get the values from the form
    $product_name = $_POST['p_name'];
    $new_qty = $_POST['p_qty'];
    $new_price = $_POST['p_price'];

    // Get the current date and time
    $purchase_date = date("Y-m-d H:i:s"); // Change the format as needed

    // Update the "new_qty" and "purchase_date" in the "tb_product" table
    $sql = "UPDATE tb_product SET new_qty = $new_qty, purchase_date = '$purchase_date', new_price=$new_price WHERE name = '$product_name'";

    if (mysqli_query($conn, $sql)) {
        // Quantity updated successfully, redirect to inventory.php
        header("Location: inventory.php");
        exit; // Make sure to exit to stop further script execution
    } else {
        echo "Error updating quantity: " . mysqli_error($conn);
    }
}
?>