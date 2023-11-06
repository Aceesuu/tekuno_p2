<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id'])) {
    // Redirect to index.php or login page if user is not logged in
    header("Location: index.php"); // Update with your login page URL
    exit();
}


include("mysql_connect.php");
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
    // Now you can use $user_data to access user information
} else {
    // Handle the case where user data couldn't be retrieved
    $error_message = "Error: Unable to retrieve user data.";
}

if (isset($_POST['category'])) {
    $category = $_POST['category'];

    $sql = "SELECT * FROM tb_product WHERE category = '$category'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($fetch_product = mysqli_fetch_assoc($result)) {
            $product_id = $fetch_product['product_id'];
            $product_name = $fetch_product['name'];
            $product_price = $fetch_product['price'];

            // You can use similar code as in your original loop for displaying products
            // Echo the HTML for each product
            echo '<form action="product_detail.php" method="get">';
            echo '<div class="box">';
            echo '<a href="product_detail.php?product_id=' . $product_id . '">';
            echo '<img src="uploaded_img/' . $fetch_product['image'] . '" alt="">';
            echo '</a>';
            echo '<div class="details">';
            echo '<h3>';
            echo '<a href="product_detail.php?product_id=' . $product_id . '">' . $product_name . '</a>';
            echo '</h3>';
            echo '<div class="price">₱' . $product_price . '</div>';
            echo '</div>';
            echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
            echo '<input type="submit" class="btn" value="View Product" name="add_to_cart" style="text-align: center;">';
            echo '</div>';
            echo '</form>';
        }
    } else {
        echo "No products found for this category";
    }
}
?>