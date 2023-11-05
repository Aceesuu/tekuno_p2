<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "mysql_connect.php";

if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];

    // Check if the selected product exists and retrieve its ID
    $check_product_query = $conn->prepare("SELECT product_id FROM tb_product WHERE name = ?");
    $check_product_query->bind_param("s", $p_name);
    $check_product_query->execute();
    $check_product_query->store_result();

    if ($check_product_query->num_rows > 0) {
        $check_product_query->bind_result($product_id);
        $check_product_query->fetch();
        $check_product_query->close();

        if (isset($_POST['variation'])) {
            $product_variation_query = $conn->prepare("INSERT INTO product_variation (product_id, name, variation, supplier_price, price, qty) VALUES (?, ?, ?, ?, ?, ?)");

            $variations = $_POST['variation'];
            $supplier_prices = $_POST['supplier_price'];
            $quantities = $_POST['qty'];

            for ($i = 0; $i < count($variations); $i++) {
                $individual_variation = $variations[$i];
                $individual_supplier_price = $supplier_prices[$i];
                $individual_price = $_POST['price'][$i];
                $individual_qty = $quantities[$i];

                // Bind the parameters for variations and insert them
                $product_variation_query->bind_param("isssss", $product_id, $p_name, $individual_variation, $individual_supplier_price, $individual_price, $individual_qty);
                $product_variation_query->execute();
            }

            $product_variation_query->close();
            $message[] = 'Variations added successfully';
            header('location: manage_product.php');
        } else {
            $message[] = 'Please provide all variation details (color, size, and variant)';
            header('location: manage_product.php');
        }
    } else {
        // Handle other cases or provide an error message
    }
}



if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_variant = $_POST['update_p_variant'];
    $update_sup = $_POST['update_sup'];
    $update_p_price = $_POST['update_p_price'];
    $update_qty = $_POST['update_qty'];

    // Assuming you have a database connection named $conn
    $update_query = mysqli_query($conn, "UPDATE `product_variation` SET variation = '$update_p_variant', supplier_price = '$update_sup', price = '$update_p_price', qty = '$update_qty' WHERE variation_id = '$update_p_id'");

    // Check if the update was successful
    if ($update_query) {
        // Redirect to manage_product.php after a successful update
        header("Location: manage_product.php");
        exit();
    } else {
        // Handle the update failure, e.g., display an error message
        echo "Update failed: " . mysqli_error($conn);
    }
} else {
    // If the form wasn't submitted via POST, redirect to manage_product.php
    header("Location: manage_product.php");
    exit();
}

?>

