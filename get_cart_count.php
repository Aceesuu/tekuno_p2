<?php
include "mysql_connect.php";

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    // Query to get the distinct count of products in the user's cart
    $cart_count_query = mysqli_query($conn, "SELECT COUNT(DISTINCT product_id) AS total_products FROM `tb_cart` WHERE user_id = '$user_id'");
    
    if ($cart_count_query) {
        $cart_count_row = mysqli_fetch_assoc($cart_count_query);
        $cart_count = $cart_count_row['total_products'];
        echo $cart_count;
    } else {
        echo '0'; // Default to 0 if there was an error in the query
    }
} else {
    echo '0'; // Default to 0 if the user is not logged in
}
?>