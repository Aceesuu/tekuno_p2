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
?>
<div class="container">
    <section class="products">
        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `tb_product`");
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                    $product_id = $fetch_product['product_id'];
                    $product_name = $fetch_product['name'];
                    $product_price = $fetch_product['price'];

                    // Check if there are variations for this product with valid prices
                    $select_variations = mysqli_query($conn, "SELECT MIN(price) AS min_price, MAX(price) AS max_price FROM `product_variation` WHERE product_id = '$product_id' AND price IS NOT NULL");
                    $variation_row = mysqli_fetch_assoc($select_variations);
                    $min_price = $variation_row['min_price'];
                    $max_price = $variation_row['max_price'];

                    // Determine the display price
                    if ($min_price !== null && $max_price !== null && $min_price == $max_price) {
                        // All variations have the same price
                        $price_display = "₱$min_price";
                    } else {
                        // Price variations exist, so display the price range
                        if ($min_price !== null && $max_price !== null) {
                            $price_display = "₱$min_price - ₱$max_price";
                        } else {
                            // If there are variations but no valid prices, fall back to the product price
                            $price_display = "₱$product_price";
                        }
                    }
            ?>

                    <form action="product_detail.php" method="get">
                        <div class="box">
                            <a href="product_detail.php?product_id=<?php echo $product_id; ?>">
                                <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                            </a>
                            <div class="details">
                                <h3>
                                    <a href="product_detail.php?product_id=<?php echo $product_id; ?>">
                                        <?php echo $product_name; ?>
                                    </a>
                                </h3>
                                <div class="price"><?php echo $price_display; ?></div>
                            </div>
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <input type="submit" class="btn" value="View Product" name="add_to_cart" style="text-align: center;">

                        </div>
                    </form>
            <?php
                }
            }
            ?>
        </div>
    </section>
</div>