<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "mysql_connect.php";
//DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['variation_id'])) {
        $variation_id = mysqli_real_escape_string($conn, $_POST['variation_id']);

        $query = "DELETE FROM product_variation WHERE variation_id='$variation_id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Variation Deleted Successfully";
            header('location: role_manage_products.php');
        } else {
            $_SESSION['message'] = "Variation Not Deleted";
        }
    }
}

?>