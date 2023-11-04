<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "mysql_connect.php";

if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_desc = $_POST['p_desc'];
    $p_price = $_POST['p_price'];
    $p_qty = $_POST['p_qty'];
    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $p_image_folder = 'uploaded_img/' . $p_image;

    // Prepare the SQL statement with placeholders
    $insert_query = $conn->prepare("INSERT INTO tb_product (name, prod_desc, price, qty, image) VALUES (?, ?, ?, ?, ?)");

    // Bind the parameters to the prepared statement
    $insert_query->bind_param("ssdis", $p_name, $p_desc, $p_price, $p_qty, $p_image);

    // Execute the prepared statement
    if ($insert_query->execute()) {
        move_uploaded_file($p_image_tmp_name, $p_image_folder);
        $message[] = 'Product added successfully';
        header('location: products.php');
    } else {
        $message[] = 'Could not add the product';
        header('location: products.php');
    }

    // Close the prepared statement
    $insert_query->close();
}


if (isset($_POST['update_product'])) {
$update_p_id = $_POST['update_p_id'];
$update_p_name = $_POST['update_p_name'];
$update_p_desc = $_POST['update_p_desc'];
$update_p_price = $_POST['update_p_price'];
$update_p_qty = $_POST['update_p_qty'];
$update_p_image = $_FILES['update_p_image']['name'];
$update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
$update_p_image_folder = 'uploaded_img/' . $update_p_image;

$update_query = mysqli_query($conn, "UPDATE `tb_product` SET name = '$update_p_name', prod_desc = '$update_p_desc', price = '$update_p_price',qty = $update_p_qty, image = '$update_p_image' WHERE product_id = '$update_p_id'");

if ($update_query) {
move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
$message = 'product updated successfully';
header('location:products.php');
} else {
$message = 'product could not be updated';
header('location:products.php');
}
}

//DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

        $query = "DELETE FROM tb_product WHERE product_id='$product_id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "product_id Deleted Successfully";
            header('location: manage_product.php');
        } else {
            echo "product_id Not Deleted";
        }
    }
}

header("Location: products.php");
exit(0);
?>