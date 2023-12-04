<?php
include "mysql_connect.php";
session_start(); // Start the session


// Check if the 'product_id' query parameter is present in the URL
// Function to add a product to the cart
function addProductToCart($conn, $user_id, $product_id, $product_name, $product_image, $product_quantity, $selected_variation = null) {
    $product_price = $_POST['product_price'];
    $subtotal = $product_price * $product_quantity;
    $discount = 0;

    if ($product_quantity >= 5) {
        $discount = $subtotal * 0.10;
    }

    if ($selected_variation !== null) {
        $variation_query = mysqli_query($conn, "SELECT price FROM `product_variation` WHERE product_id = '$product_id' AND variation = '$selected_variation'");

        if ($variation_query && mysqli_num_rows($variation_query) === 1) {
            $row = mysqli_fetch_assoc($variation_query);
            $product_price = $row['price'];

            $subtotal = $product_price * $product_quantity;
        } else {
            $message[] = 'Selected variation is not available for this product';
            return false;
        }
    }

    $select_cart_query = mysqli_query($conn, "SELECT * FROM `tb_cart` WHERE user_id = '$user_id' AND product_id = '$product_id' AND variation = '$selected_variation'");
    if (mysqli_num_rows($select_cart_query) > 0) {
        $existing_product = mysqli_fetch_assoc($select_cart_query);
        $existing_quantity = $existing_product['quantity'];

        $new_subtotal = $product_price * ($existing_quantity + $product_quantity);
        $new_discount = 0;

        if (($existing_quantity + $product_quantity) >= 5) {
            $new_discount = $new_subtotal * 0.10;
        }

        $update_quantity_query = mysqli_query($conn, "UPDATE `tb_cart` SET quantity = quantity + '$product_quantity', subtotal = '$new_subtotal', discount = '$new_discount' WHERE user_id = '$user_id' AND product_id = '$product_id' AND variation = '$selected_variation'");

        if ($update_quantity_query) {
            $message[] = 'Product quantity updated in cart';
        } else {
            $message[] = 'Failed to update product quantity in cart';
        }
    } else {
        $insert_product_query = mysqli_query($conn, "INSERT INTO `tb_cart`(user_id, product_id, name, price, image, quantity, variation, subtotal, discount) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity', '$selected_variation', '$subtotal', '$discount')");
        if ($insert_product_query) {
            $message[] = 'Product added to cart successfully';
        } else {
            $message[] = 'Failed to add product to cart';
        }
    }
    return true;
}

if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product details from the database based on the product_id
    $query = "SELECT * FROM `tb_product` WHERE `product_id` = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $product = mysqli_fetch_assoc($result);

        if ($product['qty'] > 0) {
            if (isset($_POST['add_to_cart'])) {
                $user_id = $_SESSION['user_id'];
                $product_id = $_POST['product_id'];
                $product_name = $_POST['product_name'];
                $product_image = $_POST['product_image'];
                $product_quantity = isset($_POST['product_quantity']) ? intval($_POST['product_quantity']) : 1;
                $selected_variation = isset($_POST['variation']) ? $_POST['variation'] : null;

                // Check if the requested quantity exceeds the available stock
                if ($product_quantity > $product['qty']) {
                    $message[] = 'Requested quantity exceeds available stock.';
                } else {
                    addProductToCart($conn, $user_id, $product_id, $product_name, $product_image, $product_quantity, $selected_variation);
                    $message1[] = 'Product added to cart successfully';
                }
            }
        } else {
            $message2[] = 'This product is currently out of stock.';
        }
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

$variations_query = $conn->prepare("SELECT variation, price FROM product_variation WHERE product_id = ?");
$variations_query->bind_param("i", $product_id);
$variations_query->execute();
$variations_result = $variations_query->get_result();
$variations = array();

while ($row = $variations_result->fetch_assoc()) {
    $variations[] = array(
        'variation' => $row['variation'],
        'price' => $row['price']
    );
}
$variations_query->close();

// Fetch and display the user's first name and last name
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Produt Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="assets/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">
    <link href="css/detail1.css" rel="stylesheet" />

</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom topnav-navbar" style="background-color: #212A37;">
                    <div class="container-fluid">

                        <!-- LOGO -->
                        <a href="" class="topnav-logo">
                            <span class="topnav-logo-lg">
                                <img src="assets/images/logo.png" alt="" height="67">
                            </span>
                            <span class="topnav-logo-sm">
                                <img src="assets/images/logo.png" alt="" height="70">
                            </span>
                        </a>

                        <ul class="list-unstyled topbar-menu float-end mb-0">

                            <li class="dropdown notification-list">
                                <!-- Add to Home link -->
                                <a class="nav-link" href="dashboard-customer.php" style="display: flex; align-items: center;">
                                    <i class="mdi mdi-home-outline" style="font-size: 27px; margin-top: 15px;"></i>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to Cart link -->
                                <a class="nav-link" href="addcart.php" style="display: flex; align-items: center;">
                                    <i class='uil uil-shopping-cart-alt' style="font-size: 25px; margin-top: 15px;"></i>
                                    <span id="cart-count" class="red-number">0</span>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to proof link -->
                                <a class="nav-link" href="order_customer.php" style="display: flex; align-items: center;">
                                    <i class="mdi mdi-inbox-multiple" style="font-size: 25px; margin-top: 15px;"></i>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to proof link -->
                                <a class="nav-link" href="proof_customer.php" style="display: flex; align-items: center;">
                                    <i class="dripicons-wallet" style="font-size: 24px; margin-top: 15px;"></i>
                                </a>
                            </li>

              <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="dripicons-bell noti-icon"></i>
                                    <span class="noti-icon-badge"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg" aria-labelledby="topbar-notifydrop">

                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                            <span class="float-end">

                                            </span>Notification

                                        </h5>
                                    </div>


                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `user_id` = $user_id ORDER BY `order_id` DESC, `order_date` ASC LIMIT 5");

                                    if (mysqli_num_rows($sql) > 0) {
                                        $orders = array();

                                        while ($row = mysqli_fetch_assoc($sql)) {
                                            $order_id = $row['order_id'];

                                            // Use order_id as the key and update the status if a newer one is found
                                            if (!isset($orders[$order_id]) || $row['order_date'] > $orders[$order_id]['order_date']) {
                                                $orders[$order_id] = array(
                                                    'order_id' => $order_id,
                                                    'status' => $row['order_status'],
                                                    'order_date' => $row['order_date'],
                                                );
                                            }
                                        }

                                        foreach ($orders as $order) {
                                    ?>
                                            <div style="max-height: 230px;" data-simplebar="">

                                                <a href="order_customer.php" class="dropdown-item notify-item">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                    <p class="notify-details">Your Order # <?php echo $order['order_id']; ?> has the <br>
                                                        status of <?php echo $order['status']; ?></p>
                                                    <small class="text-muted"><?php echo $order['order_date']; ?></small>
                                                    </p>
                                                </a>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<a href="#" class="dropdown-item notify-item">';
                                        echo '    <p class="notify-details">No orders</p>';
                                        echo '</a>';
                                    }
                                    ?>

                                    <!-- All-->
                                    <a href="viewall_notif.php" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View All
                                    </a>

                                </div>

                            </li>


                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 custom-bg-color" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="position: relative; top: -1px;">
                                    <span class="account-user-avatar">
                                        <?php
                                        $user_image = $user_data['image'];
                                        if (!empty($user_image)) {
                                            // Display the user's image if available
                                            echo '<img src="uploaded_img/' . $user_image . '" alt="user" class="rounded-circle">';
                                        } else {
                                            // Display a default avatar image when no user image is available
                                            echo '<img src="assets/images/profile.jpg" alt="Default Avatar" class="rounded-circle">';
                                        }
                                        ?>
                                    </span>
                                    <span>
                                        <span class="account-user-name"><?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                                    <!-- item-->
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span>My Account</span>
                                    </a>
                                       <a href="order_history.php" class="dropdown-item notify-item">
                                        <i class=" mdi mdi-briefcase-clock"></i>
                                        <span>Order History</span>
                                    </a>

                                    <!-- item-->
                                    <a href="logout.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- end Topbar -->

                <?php

                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div class="alert alert-danger" role="alert"><center> Requested quantity exceeds available stock.</center>
                                </div>';
                    };
                };

                ?>

                <?php

                if (isset($message1)) {
                    foreach ($message1 as $message1) {
                        echo '<div class="alert alert-success" role="alert"><center>
                                ' . $message1 . '
                              </center></div>';
                    };
                };

                ?>

                <?php

                if (isset($message2)) {
                    foreach ($message2 as $message2) {
                        echo '<div class="alert alert-danger" role="alert"><center> This product is currently out of stock! </center>
                                </div>';
                    };
                };

                ?>

                <!-- ============================================================== -->
                <!-- Start Page Content here -->
                <!-- ============================================================== -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard-customer.php">Home</a></li>
                                        <li class="breadcrumb-item active">Product Details</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Product Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <a href="dashboard-customer.php"><i class="dripicons-chevron-left"></i>Back</a>
                                            <!-- Product image -->
                                            <a href="#" class="text-center d-block mb-4">
                                                <img src="uploaded_img/<?php echo $product['image']; ?>" alt="Product-img" class="img-fluid" style="max-width: 280px;">
                                            </a>
                                        </div> <!-- end col -->
                                        <div class="col-lg-7">
                                            <form class="ps-lg-4" action="" method="post">
                                                <!-- Product title -->
                                                <h3 class="mt-0">
                                                    <h1><?php echo $product['name']; ?></h1>
                                                </h3>
                                                <p class="font-16">
                                                <h4>
                                                     <span class="badge <?php echo ($product['qty'] > 0) ? 'badge-success-lighten' : 'badge-danger-lighten'; ?>">
                                                        <?php echo ($product['qty'] > 0) ? 'Instock' : 'Out of Stock'; ?>
                                                    </span>
                                                </h4>
                                                <h5><span>Stocks:</span>&nbsp<?php echo $product['qty']; ?></h5>

                                                </p>

                                                <!-- Product price -->
                                                <div class="mt-4">
                                                    <h6 class="font-14">Price:</h6>
                                                    <h3 id="displayed_price">₱<?php echo !empty($variations) ? $variations[0]['price'] : $product['price']; ?></h3>
                                                </div>

                                                <!-- Variation options -->
                                                <?php if (!empty($variations)) { ?>
                                                    <div class="mt-4">
                                                        <h6 class="font-14">Variation:</h6>
                                                        <select name="variation" class="form-select" onchange="updatePrice(this)">
                                                            <?php
                                                            foreach ($variations as $variation) {
                                                                echo '<option value="' . $variation['variation'] . '" data-price="' . $variation['price'] . '">' . $variation['variation'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                        <input type="hidden" name="selected_variation" id="selected_variation" value="">
                                                    </div>
                                                <?php } ?>

                                                <!-- Quantity -->
                                                <div class="mt-4">
                                                    <h6 class="font-14">Quantity</h6>
                                                    <div class="d-flex">
                                                        <input type="number" min="1" name="product_quantity" value="1" class="form-control" placeholder="Qty" style="width: 90px;">
                                                        <?php
                                                        if ($product['qty'] > 0) {
                                                            // Product is in stock, so the button is active
                                                            echo '<button type="submit" class="btn btn-danger ms-2" name="add_to_cart"><i class="mdi mdi-cart me-1"></i> Add to cart</button>';
                                                        } else {
                                                            // Product is out of stock, so the button is disabled
                                                            echo '<button type="submit" class="btn btn-danger ms-2" name="add_to_cart" disabled><i class="mdi mdi-cart me-1"></i> Add to cart</button>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <!-- Product description -->
                                                <div class="mt-4">
                                                    <h6 class="font-14">Description:</h6>
                                                    <p><?php echo $product['prod_desc']; ?></p>
                                                </div>

                                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                                                <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">

                                            </form>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            © TEKUNO
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script>
        // Function to update the displayed price based on the selected variation
        function updatePrice(select) {
            var selectedVariation = select.value;
            var priceElement = document.getElementById('displayed_price');
            var option = select.options[select.selectedIndex];
            var price = option.getAttribute('data-price');

            // Update the displayed price
            priceElement.textContent = '₱' + price;
        }

        // Trigger the function on page load to initialize the displayed price
        window.addEventListener('load', function() {
            var select = document.querySelector('select[name="variation"]');
            updatePrice(select);
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to update the cart count from the server
        function updateCartCount() {
            $.ajax({
                url: 'get_cart_count.php', // Replace with the actual URL of your PHP script
                method: 'GET',
                success: function(response) {
                    $('#cart-count').text(response);
                },
                error: function() {
                    // Handle the error if the request fails
                    console.error('Failed to fetch cart count');
                }
            });
        }

        // Call the updateCartCount function to initialize the cart count
        updateCartCount();
    </script>



</body>

</html>