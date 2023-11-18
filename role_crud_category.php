<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "mysql_connect.php";

if (isset($_POST['add_product'])) {
    $category_name = $_POST['category_name'];

    $insert_query = $conn->prepare("INSERT INTO tb_category (category_name) VALUES (?)");

    if ($insert_query) {
        $insert_query->bind_param("s", $category_name);

        if ($insert_query->execute()) {
            $message[] = 'Category added successfully';
            header('location: role_category.php');
        } else {
            $message[] = 'Could not add the category';
        }
        $insert_query->close();
    } else {
        $message[] = 'Prepare statement failed';
    }
}

if (isset($_POST['update_product'])) {
    $update_p_id = $_POST['update_p_id'];
    $update_p_cat = $_POST['update_p_cat'];

    $update_query = mysqli_query($conn, "UPDATE `tb_category` SET category_name = '$update_p_cat' WHERE category_id = '$update_p_id'");

    // Check if the update was successful
    if ($update_query) {
        // Redirect to manage_product.php after a successful update
        header("Location: role_category.php");
        exit();
    } else {
        // Handle the update failure, e.g., display an error message
        echo "Update failed: " . mysqli_error($conn);
    }
} else {
    header("Location: role_category.php");
    exit();
}

//DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_id'])) {
        $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

        $query = "DELETE FROM tb_category WHERE category_id='$category_id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            echo "category_id Deleted Successfully";
            header('location: role_category.php');
        } else {
            echo "category_id Not Deleted";
        }
    }
}

header("Location: role_category.php");
exit(0);


?>