<?php
include "mysql_connect.php";
session_start(); // Start the session

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
} else {
    $error_message = "Error: Unable to retrieve user data.";
}

//ADD TO CART
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $product_price = $_POST['product_price'];

    if (isset($_POST['product_quantity'])) {
        $product_quantity = intval($_POST['product_quantity']);
    } else {
        $product_quantity = 1;
    }

    // subtotal each product
    $subtotal = $product_price * $product_quantity;

    $discount = 0;

    if ($product_quantity >= 5) {
        $discount = $subtotal * 0.10;
    }

    if (isset($_POST['variation'])) {
        $selected_variation = $_POST['variation'];

        // Fetch the price of the selected variation from the database
        $variation_query = mysqli_query($conn, "SELECT price FROM `product_variation` WHERE product_id = '$product_id' AND variation = '$selected_variation'");

        if ($variation_query && mysqli_num_rows($variation_query) === 1) {
            $row = mysqli_fetch_assoc($variation_query);
            $product_price = $row['price'];

            // Calculate the subtotal for this product with variation
            $subtotal = $product_price * $product_quantity;

            // Check if the discount should be applied
            $discount = 0; // Default to no discount

            if ($product_quantity >= 5) {
                $discount = $subtotal * 0.10; // 10% discount when quantity is 5 or more
            }

            // Check if the product is already in the cart with the same variation
            $select_cart = mysqli_query($conn, "SELECT * FROM `tb_cart` WHERE user_id = '$user_id' AND variation = '$selected_variation'");

            if (mysqli_num_rows($select_cart) > 0) {
                // The product with the same variation is already in the cart
                $existing_product = mysqli_fetch_assoc($select_cart);
                $existing_quantity = $existing_product['quantity'];

                // Calculate the new subtotal and discount for the updated quantity
                $new_subtotal = $product_price * ($existing_quantity + $product_quantity);
                $new_discount = 0;

                if (($existing_quantity + $product_quantity) >= 5) {
                    $new_discount = $new_subtotal * 0.10;
                }

                // Update the quantity, subtotal, and discount
                $update_quantity_query = mysqli_query($conn, "UPDATE `tb_cart` SET quantity = quantity + '$product_quantity', subtotal = '$new_subtotal', discount = '$new_discount' WHERE user_id = '$user_id' AND variation = '$selected_variation'");

                if ($update_quantity_query) {
                    $message[] = 'Product quantity updated in cart';
                } else {
                    $message[] = 'Failed to update product quantity in cart';
                }
            } else {
                // Insert the product with the selected variation into the cart
                $insert_product = mysqli_query($conn, "INSERT INTO `tb_cart`(user_id, product_id, name, price, image, quantity, variation, subtotal, discount) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity', '$selected_variation', '$subtotal', '$discount')");
                if ($insert_product) {
                    $message[] = 'Product added to cart successfully';
                } else {
                    $message[] = 'Failed to add product to cart';
                }
            }
        } else {
            $message[] = 'Selected variation is not available for this product';
        }
    } else {
        $select_cart_no_variation = mysqli_query($conn, "SELECT * FROM `tb_cart` WHERE user_id = '$user_id' AND variation IS NULL AND product_id = '$product_id'");

        if (mysqli_num_rows($select_cart_no_variation) > 0) {

            $update_quantity_query = mysqli_query($conn, "UPDATE `tb_cart` SET quantity = quantity + '$product_quantity', subtotal = price * (quantity + '$product_quantity') WHERE user_id = '$user_id' AND variation IS NULL AND product_id = '$product_id'");
            if ($update_quantity_query) {
                $message[] = 'Product quantity updated in cart';
            } else {
                $message[] = 'Failed to update product quantity in cart';
            }
        } else {
            // Insert the product without a variation into the cart
            $insert_product = mysqli_query($conn, "INSERT INTO `tb_cart` (user_id, product_id, name, price, image, quantity, subtotal, discount) VALUES ('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', '$product_quantity', '$subtotal', '$discount')");
            if ($insert_product) {
                $message[] = 'Product added to cart successfully';
            } else {
                $message[] = 'Failed to add product to cart';
            }
        }
    }
}


if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `tb_cart` SET quantity = '$update_value' WHERE cart_id = '$update_id'");
    if ($update_quantity_query) {
        header('location:addcart.php');
    };
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `tb_cart` WHERE cart_id = '$remove_id'");
    header('location:addcart.php');
};

if (isset($_GET['delete_all'])) {
    $user_id = $_SESSION['user_id'];
    mysqli_query($conn, "DELETE FROM `tb_cart` WHERE user_id = '$user_id'");
    header('location:addcart.php');
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kat & Ren Construction Supply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logo1.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="css/product1.css" rel="stylesheet" />
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
                                <img src="assets/images/logo1.png" alt="" height="69">
                            </span>
                            <span class="topnav-logo-sm">
                                <img src="assets/images/logo1.png" alt="" height="69">
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
                                                <a href="javascript: void(0);" class="text-dark">
                                                    <small>Clear All</small>
                                                </a>
                                            </span>Notification
                                        </h5>
                                    </div>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View All
                                    </a>

                                </div>
                            </li>

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 custom-bg-color" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="account-user-avatar">
                                        <?php
                                        $user_image = $user_data['image'];
                                        if (!empty($user_image)) {
                                            // Display the user's image if available
                                            echo '<img src="user_profile_img/' . $user_image . '" alt="user" class="rounded-circle">';
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
                                    <a href="user_profile.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span>My Account</span>
                                    </a>

                                    <!-- item-->
                                    <a href="logout.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>
                        <a class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>

                    </div>
                </div>
                <!-- end Topbar -->

                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Shopping Cart</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-centered mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Product</th>
                                                            <th>Price</th>
                                                            <th>Quantity</th>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th style="width: 50px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $user_id = $_SESSION['user_id'];
                                                        $select_cart = mysqli_query($conn, "SELECT * FROM tb_cart WHERE user_id = '$user_id'");

                                                        $grand_total = 0;
                                                        $total_discount = 0;
                                                        $sub_total = 0;
                                                        $discountApplied = false;
                                                        $shipping_fee = 40;
                                                        $total = 0;

                                                        if (mysqli_num_rows($select_cart) > 0) {
                                                            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                                                $quantity = $fetch_cart['quantity'];
                                                                $price = $fetch_cart['price'];

                                                                // Calculate the discount for this item
                                                                $discounted_price = 0; // Default price without discount
                                                                if ($quantity >= 5) {
                                                                    $discounted_price = $price * 0.1; // 10% discount
                                                                    $discountApplied = true; // Set the flag to true
                                                                }

                                                                //per item
                                                                $total = $price * $quantity;

                                                                $total_item_price = $price * $quantity;
                                                                $sub_total += $total_item_price; // Add the total item price to the subtotal

                                                                $total_discount = ($sub_total + $shipping_fee) * 0.10;

                                                                // Add the subtotal to the grand total
                                                                $grand_total = $sub_total + $shipping_fee
                                                        ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt="contact-img" title="contact-img" class="rounded me-3" height="65">
                                                                        <p class="m-0 d-inline-block align-middle font-16">
                                                                            <?php echo $fetch_cart['name']; ?>
                                                                            <br>
                                                                            <?php if (!empty($fetch_cart['variation'])) : ?>
                                                                                <small><b>Variation:</b> <?php echo $fetch_cart['variation']; ?></small>
                                                                            <?php endif; ?>
                                                                        </p>
                                                                    </td>
                                                                    <td>
                                                                        ₱<?php echo number_format($fetch_cart['price']); ?>
                                                                    </td>
                                                                    <td>
                                                                        <form action="" method="post">
                                                                            <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['cart_id']; ?>">
                                                                            <input type="number" name="update_quantity" class="form-control" style="width: 90px;" min="1" readonly value="<?php echo $fetch_cart['quantity']; ?>">
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                    <td><?php echo ($total); ?></td>
                                                                    </td>
                                                                    <td>
                                                                        <a href="addcart.php?remove=<?php echo $fetch_cart['cart_id']; ?>" onclick="return confirm('remove item from cart?')" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                                                    </td>
                                                                </tr>
                                                        <?php
                                                            };
                                                        }

                                                        // Subtract the total discount from the grand total
                                                        $grand_total -= $total_discount;
                                                        ?>
                                                        <tr class="table-bottom">
                                                            <td><a href="addcart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="mdi mdi-delete"></i>Empty Cart</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> <!-- end table-responsive-->

                                            <!-- action buttons-->
                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <a href="dashboard-customer.php"" class=" option-btn">
                                                        <i class="mdi mdi-arrow-left"></i> Continue Shopping </a>
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <a href="checkout.php" class="btn btn-danger <?= ($grand_total > 1) ? '' : 'disabled'; ?>"" >
                                                            <i class=" mdi mdi-cart-plus me-1"></i> Checkout </a>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </div>
                                        <!-- end col -->

                                        <div class="col-lg-4">
                                            <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                <h4 class="header-title mb-3">Order Summary</h4>

                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>Subtotal:</td>
                                                                <td>₱<?= number_format($sub_total, 2) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Shipping Fee:
                                                                </td>
                                                                <td>
                                                                    ₱ <?= number_format($shipping_fee, 2) ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Discount : </td>
                                                                <td> <?php
                                                                        if ($discountApplied) {
                                                                            echo '₱-' . number_format($total_discount, 2) . '</td>';
                                                                        } else {
                                                                            echo '₱0.00</td>';
                                                                        }
                                                                        ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Grand Total :</th>
                                                                <td>₱<?= number_format($grand_total, 2) ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- end table-responsive -->
                                            </div>

                                            <div class="alert alert-warning mt-3" role="alert">
                                                Add <strong>5 or more product</strong> and get 10% discount !
                                            </div>

                                        </div> <!-- end col -->

                                    </div> <!-- end row -->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->


        </div>


        <!-- content -->

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

    <div class="rightbar-overlay"></div>
    <!-- /End-bar -->

    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>

    <!-- third party js -->
    <script src="assets/js/vendor/apexcharts.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="assets/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->

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