<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "mysql_connect.php";

if (isset($_POST['add_product'])) {
    $p_name = $_POST['p_name'];
    $p_cat = $_POST['p_cat'];
    $p_desc = $_POST['p_desc'];
    $p_price = $_POST['p_price'];
    $p_qty = $_POST['p_qty'];
    $p_image = $_FILES['p_image']['name'];
    $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
    $p_image_folder = 'uploaded_img/' . $p_image;
    $supplier_price = $_POST['supplier_price'];

    // Prepare the SQL statement with placeholders
    $insert_query = $conn->prepare("INSERT INTO tb_product (name, category, prod_desc, price, qty, image, supplier_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_query->bind_param("sssdiss", $p_name, $p_cat, $p_desc, $p_price, $p_qty, $p_image, $supplier_price);

    // Execute the prepared statement
    if ($insert_query->execute()) {
        move_uploaded_file($p_image_tmp_name, $p_image_folder);
        $message[] = 'Product added successfully';
        header('location: role_inventory.php');
    } else {
        $message[] = 'Could not add the product';
        header('location: role_inventory.php');
    }

    // Close the prepared statement
    $insert_query->close();
}


if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_category = $_POST['update_category'];
    $update_p_desc = $_POST['update_p_desc'];
    $update_p_price = $_POST['update_p_price'];
    $update_sup = $_POST['update_sup']; // Retrieve the supplier price
    $update_p_qty = $_POST['update_p_qty'];

    // Check if a new image was uploaded
    if (!empty($_FILES['update_p_image']['name'])) {
        $update_p_image = $_FILES['update_p_image']['name'];
        $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
        $update_p_image_folder = 'uploaded_img/' . $update_p_image;

        // Move uploaded image to the folder
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);

        // Update query with the new image and supplier price (excluding expiry date)
        $update_query = mysqli_query($conn, "UPDATE `tb_product` SET name = '$update_p_name', category = '$update_p_category', prod_desc = '$update_p_desc', price = '$update_p_price', supplier_price = '$update_sup', qty = $update_p_qty, image = '$update_p_image' WHERE product_id = '$update_p_id'");
    } else {
        // No new image was uploaded, so use the existing image value and update the supplier price (excluding expiry date)
        $update_query = mysqli_query($conn, "UPDATE `tb_product` SET name = '$update_p_name', category = '$update_p_category', prod_desc = '$update_p_desc', price = '$update_p_price', supplier_price = '$update_sup', qty = $update_p_qty WHERE product_id = '$update_p_id'");
    }

    if ($update_query) {
        $message = 'Product updated successfully';
        header('location: role_inventory.php');
    } else {
        $message = 'Product could not be updated';
        header('location: role_inventory.php');
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
            header('location: role_inventory.php');
        } else {
            echo "product_id Not Deleted";
        }
    }
}

header("Location: role_inventory.php");
exit(0);
?>