<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "mysql_connect.php";
//DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category_id'])) {
        $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

        $query = "DELETE FROM tb_category WHERE category_id='$category_id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "category Deleted Successfully";
            header('location: role_category.php');
        } else {
            $_SESSION['message'] = "category Not Deleted";
        }
    }
}
?>