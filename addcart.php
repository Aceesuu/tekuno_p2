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

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `tb_cart` SET quantity = '$update_value' WHERE cart_id = '$update_id'");

    if ($update_quantity_query) {
        $message[] = "Quantity updated successfully."; // Add success message to the array
    } else {
        $message[] = "Error updating quantity."; // Add error message to the array
    }
}

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
    <link href="css/prod1.css" rel="stylesheet" />
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
               <div class="navbar-custom topnav-navbar" style="background-color: #212A37; height: 85px;">
                    <div class="container-fluid">

                        <!-- LOGO -->
                        <a href="" class="topnav-logo">
                            <span class="topnav-logo-lg">
                                <img src="assets/images/logo.png" alt="" height="69">
                            </span>
                            <span class="topnav-logo-sm">
                                <img src="assets/images/logo.png" alt="" height="69">
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
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 custom-bg-color" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="position: relative; top: 5px;">
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
                                    <a href="user_profile.php" class="dropdown-item notify-item">
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
                
                <?php

                if (isset($message)) {
                    foreach ($message as $message) {
                        echo '<div class="alert alert-success" role="alert"><center>
                                ' . $message . '
                              </center></div>';
                    };
                };

                ?>

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
                                            <a href="javascript:history.back()"><i class="dripicons-chevron-left"></i>Back</a><br><br>
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
                                                        $total = 0;
                                                        $sub_total = 0;
                                                        $shipping_fee = 40;
                                                        $discounted_price = 0;
                                                        $discount_rate = 0.03;

                                                        if (mysqli_num_rows($select_cart) > 0) {
                                                            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                                                $quantity = $fetch_cart['quantity'];
                                                                $price = $fetch_cart['price'];

                                                                // Calculate the total for this item
                                                                $item_total = $price * $quantity;
                                                                // Add this item's total to the overall total
                                                                $total += $item_total;

                                                                $sub_total += $item_total;

                                                                if ($sub_total >= 5000) {
                                                                    $discounted_price = $sub_total * (1 - $discount_rate); // Apply the 3% discount
                                                                } else {
                                                                    $discounted_price = $sub_total; // No discount
                                                                }
                                                        ?>
                                                                <tr>
                                                                    <td>
                                                                        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt="product-img" class="rounded me-3" height="65">
                                                                        <p class="m-0 d-inline-block align-middle font-16">
                                                                            <a href="product_detail.php" class="text-body"><?php echo $fetch_cart['name']; ?></a>
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
                                                                            <input type="number" name="update_quantity" class="form-control" style="width: 90px;" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                                                                            <input type="submit" class="form-control" style="width: 90px;" value="update" name="update_update_btn">
                                                                        </form>
                                                                    </td>
                                                                    <td>
                                                                    <td><?php echo ($item_total); ?></td>
                                                                    </td>
                                                                    <td>
                                                                        <a href="addcart.php?remove=<?php echo $fetch_cart['cart_id']; ?>" onclick="return confirm('remove item from cart?')" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                                                    </td>
                                                                </tr>
                                                        <?php
                                                            };
                                                        }

                                                        // Calculate tax on the discounted sub total
                                                        $tax = $discounted_price * 0.12;

                                                        // Calculate the grand total
                                                        $grand_total = $discounted_price + $tax + $shipping_fee;
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
                                                    <a href="dashboard-customer.php" class=" option-btn">
                                                        <i class="mdi mdi-arrow-left"></i> Continue Shopping </a>
                                                </div> <!-- end col -->
                                                <div class="col-sm-6">
                                                    <div class="text-sm-end">
                                                        <a href="checkout.php" class="btn btn-danger <?= ($grand_total > 1) ? '' : 'disabled'; ?>">
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
                                                            <?php if ($sub_total >= 5000) { ?>
                                                                <tr>
                                                                    <td>Discounted Rate :</td>
                                                                    <td>3%</td>
                                                                </tr>
                                                            <tr>
                                                                <td>Discounted Price : </td>
                                                                <td> ₱<?= number_format($discounted_price, 2) ?></td>
                                                            </tr>
                                                            <?php } ?>

                                                            <tr>
                                                                <td>Sales Tax:</td>
                                                                <td> ₱<?= number_format($tax, 2) ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Shipping Fee:
                                                                </td>
                                                                <td>
                                                                    ₱<?= number_format($shipping_fee, 2) ?>
                                                                </td>
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
                                                <strong>Worth ₱5000</strong> and get 3% discount !
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