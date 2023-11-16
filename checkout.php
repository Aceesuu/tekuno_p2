<?php
session_start(); // Start the session
include "mysql_connect.php";

if (!isset($_SESSION['user_id'])) {
    // Redirect to index.php or login page if user is not logged in
    header("Location: index.php"); // Update with your login page URL
    exit();
}

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
    <title>Kat & Ren Construction Supply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/check.css">

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
                                <img src="assets/images/logo.png" alt="" height="67">
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
                                <!-- Add to proof link -->
                                <a class="nav-link" href="order_customer.php" style="display: flex; align-items: center;">
                                    <i class="mdi mdi-inbox-multiple" style="font-size: 25px; margin-top: 15px;"></i>
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
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
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

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Checkout Steps -->
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                        <li class="nav-item">
                                            <a href="#shipping-information" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                <i class="mdi mdi-truck-fast font-18"></i>
                                                <span class="d-none d-lg-block">Shipping Info</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#payment-information" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                                <i class="mdi mdi-cash-multiple font-18"></i>
                                                <span class="d-none d-lg-block">Payment Info</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Steps Information -->
                                    <div class="tab-content">
                                        <!-- Shipping Content-->
                                        <div class="tab-pane show active" id="shipping-information">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h4 class="mt-2">Saved Address</h4>

                                                    <p class="text-muted mb-3">The form below is saved address in order to
                                                        send you the order's invoice.</p>

                                                    <div class="row">
                                                   <div class="col-md-6 w-70">
                                                   <div class="border p-3 rounded mb-3 mb-md-0"> 
                                                                <?php
                                                                $select_query = mysqli_query($conn, "SELECT * FROM `tb_user` WHERE user_id = '$user_id'");
                                                                if (mysqli_num_rows($select_query) > 0) {
                                                                    while ($fetch_query = mysqli_fetch_assoc($select_query)) {
                                                                        $addressComplete = !empty($fetch_query['houseNo']) && !empty($fetch_query['street']) && !empty($fetch_query['barangay']) && !empty($fetch_query['postal']);
                                                                ?>
                                                                        <h6>Address:</h6>
                                                                        <h5><?php echo $fetch_query['firstName'] . ' ' . $fetch_query['lastName']; ?></h5>
                                                                        <address class="mb-0 font-14 address-lg">
                                                                            <?php echo $fetch_query['houseNo'] . ' ' . $fetch_query['street']; ?><br>
                                                                            <?php echo $fetch_query['village'] . ' ' . $fetch_query['barangay']; ?><br>
                                                                            <?php echo $fetch_query['postal'] ?>
                                                                            <?php if (!$addressComplete) { ?>
                                                                                <br>City of Pasig<br>
                                                                                <abbr title="Phone">Phone:</abbr> <?php echo $fetch_query['contact'] ?> <br>
                                                                                <abbr title="Email">Email:</abbr> <?php echo $fetch_query['email'] ?> <br>
                                                                                <small><i>(Address is incomplete. Please proceed to "My Account" to fill up the complete address.)</i></small>
                                                                            <?php } ?>
                                                                        </address>
                                                                <?php
                                                                    }
                                                                }
                                                                ?>

                                                                </address>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!-- end row-->

                                                    <div class="row mt-4">
                                                        <div class="col-sm-6">
                                                            <a href="addcart.php" class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                                <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                        </div> <!-- end col -->

                                                        <div class="col-sm-6">
                                                            <div class="text-sm-end">
                                                                <?php
                                                                if ($addressComplete) {
                                                                ?>
                                                                    <a href="#payment-information" class="btn btn-danger">
                                                                        <i class="mdi mdi-cash-multiple me-1"></i> Continue to Payment
                                                                    </a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <button class="btn btn-danger disabled" disabled>
                                                                        <i class="mdi mdi-cash-multiple me-1"></i> Continue to Payment
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                    </form>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                        <h4 class="header-title mb-3">Order Summary</h4>

                                                        <div class="table-responsive">
                                                            <table class="table table-centered mb-0">
                                                                <tbody>
                                                                    <?php

                                                                    $select_cart = mysqli_query($conn, "SELECT * FROM `tb_cart` WHERE user_id = '$user_id'");

                                                                    $grand_total = 0;
                                                                    $total = 0;
                                                                    $subtotal = 0;
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

                                                                            $subtotal += $item_total;

                                                                            if ($subtotal >= 5000) {
                                                                                $discounted_price = $subtotal * (1 - $discount_rate); // Apply the 3% discount
                                                                            } else {
                                                                                $discounted_price = $subtotal; // No discount
                                                                            }
                                                                    ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="50" alt="contact-img" title="contact-img" class="rounded me-2">
                                                                                    <p class="m-0 d-inline-block align-middle">
                                                                                        <a href="#" class="text-body fw-semibold"><?php echo $fetch_cart['name']; ?></a>
                                                                                        <br>
                                                                                        <small><?php echo $fetch_cart['quantity']; ?> x <?php echo number_format($fetch_cart['price']); ?></small>
                                                                                    </p>
                                                                                </td>
                                                                                <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                                                                            </tr>

                                                                    <?php
                                                                        }
                                                                    }

                                                                    // Calculate tax on the discounted sub total
                                                                    $tax = $discounted_price * 0.12;

                                                                    // Calculate the grand total
                                                                    $grand_total = $discounted_price + $tax + $shipping_fee;

                                                                    ?>
                                                                    <tr class="text-end">
                                                                    <tr>
                                                                        <td>Subtotal:</td>
                                                                        <td>₱<?= number_format($subtotal, 2) ?></td>
                                                                    </tr>
                                                                    <?php if ($subtotal >= 5000) { ?>
                                                                        <tr>
                                                                            <td>Discounted Rate :</td>
                                                                            <td>3%</td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <tr>
                                                                        <td>Discounted Price : </td>
                                                                        <td> ₱<?= number_format($discounted_price, 2) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sales Tax:</td>
                                                                        <td> ₱<?= number_format($tax, 2) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Shipping Fee:
                                                                        </td>
                                                                        <td>
                                                                            ₱ <?= number_format($shipping_fee, 2) ?>
                                                                        </td>
                                                                    </tr>

                                                                    <tr class="text-end">
                                                                        <td>
                                                                            <h5 class="m-2"> Grand Total:</h5>
                                                                        </td>
                                                                        <td>₱<?php echo number_format($grand_total, 2); ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end table-responsive -->
                                                    </div> <!-- end .border-->

                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </div>
                                        <!-- End Billing Information Content-->

                                        <!-- Shipping Content-->
                                        <div class="tab-pane" id="payment-information">
                                            <div class="row">

                                                <div class="col-lg-8">

                                                  <!-- Pay with Gcash box-->
                                                    <div class="border p-3 mb-3 rounded">
                                                        <div class="row">
                                                            <div class="col-sm-8 text-center">
                                                                <p class=" mb-0 ps-3 pt-1"></p>
                                                                <img src="assets/images/pay.png" alt="" height="400" width="750">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pay with proof box-->
                                                    <div class="border p-3 mb-3 rounded mx-auto">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <p class="mb-0 ps-3 pt-1">Upload your proof payment</p> <br>
                                                                <form action="place_order.php" method="post" enctype="multipart/form-data">
                                                                    <input type="file" name="proof_image" id="proofFile" accept=".jpg, .jpeg, .png" required>
                                                                    <div id="filePreview"></div> <!-- Container for the file preview -->


                                                                    <div class="row mt-4">
                                                                        <div class="col-sm-6">
                                                                            <a href="addcart.php" class="btn text-muted d-none d-sm-inline-block btn-link fw-semibold">
                                                                                <i class="mdi mdi-arrow-left"></i> Back to Shopping Cart </a>
                                                                        </div> <!-- end col -->
                                                                        <div class="col-sm-6">
                                                                            <div class="text-sm-end">
                                                                                <button type="submit" name="completeOrder" class="btn btn-danger">
                                                                                    <i class="mdi mdi-cash-multiple me-1"></i> Complete Order
                                                                                </button>
                                                                            </div>
                                                                        </div> <!-- end col -->
                                                                    </div> <!-- end row -->
                                                                </form> <!-- close the form here -->
                                                            </div> <!-- end col -->
                                                        </div> <!-- end row -->
                                                    </div>

                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                        <h4 class="header-title mb-3">Order Summary</h4>

                                                        <div class="table-responsive">
                                                            <table class="table table-centered mb-0">
                                                                <tbody>
                                                                    <?php

                                                                    $select_cart = mysqli_query($conn, "SELECT * FROM `tb_cart` WHERE user_id = '$user_id'");

                                                                    $grand_total = 0;
                                                                    $total = 0;
                                                                    $subtotal = 0;
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

                                                                            $subtotal += $item_total;

                                                                            if ($subtotal >= 5000) {
                                                                                $discounted_price = $subtotal * (1 - $discount_rate); // Apply the 3% discount
                                                                            } else {
                                                                                $discounted_price = $subtotal; // No discount
                                                                            }
                                                                    ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="50" alt="contact-img" title="contact-img" class="rounded me-2">
                                                                                    <p class="m-0 d-inline-block align-middle">
                                                                                        <a href="#" class="text-body fw-semibold"><?php echo $fetch_cart['name']; ?></a>
                                                                                        <br>
                                                                                        <small><?php echo $fetch_cart['quantity']; ?> x <?php echo number_format($fetch_cart['price']); ?></small>
                                                                                    </p>
                                                                                </td>
                                                                                <td>₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                                                                            </tr>
                                                                    <?php

                                                                        }
                                                                    }


                                                                    // Calculate tax on the discounted sub total
                                                                    $tax = $discounted_price * 0.12;

                                                                    // Calculate the grand total
                                                                    $grand_total = $discounted_price + $tax + $shipping_fee;

                                                                    ?>
                                                                    <tr class="text-end">
                                                                    <tr>
                                                                        <td>Subtotal:</td>
                                                                        <td>₱<?= number_format($subtotal, 2) ?></td>
                                                                    </tr>
                                                                    <?php if ($subtotal >= 5000) { ?>
                                                                        <tr>
                                                                            <td>Discounted Rate :</td>
                                                                            <td>3%</td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <tr>
                                                                        <td>Discounted Price : </td>
                                                                        <td> ₱<?= number_format($discounted_price, 2) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sales Tax:</td>
                                                                        <td> ₱<?= number_format($tax, 2) ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Shipping Fee:
                                                                        </td>
                                                                        <td>
                                                                            ₱ <?= number_format($shipping_fee, 2) ?>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr class="text-end">
                                                                        <td>
                                                                            <h5 class="m-2"> Grand Total:</h5>
                                                                        </td>
                                                                        <td>₱<?php echo number_format($grand_total, 2); ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end table-responsive -->
                                                    </div> <!-- end .border-->

                                                </div> <!-- end col -->
                                            </div> <!-- end row-->
                                        </div>
                                        <!-- End Shipping Information Content-->

                                        <!-- Payment Content-->
                                        <div class="tab-pane" id="payment-information">
                                            <div class="row">

                                                <div class="col-lg-8">
                                                    <h4 class="mt-2">Payment Selection</h4>

                                                    <p class="text-muted mb-4">Fill the form below in order to
                                                        send you the order's invoice.</p>

                                                    <!-- Pay with Gcash box-->
                                                    <div class="border p-3 mb-3 rounded">
                                                        <div class="row">
                                                            <div class="col-sm-8 text-center">
                                                                <p class=" mb-0 ps-3 pt-1">You need to scan the QR to pay of the company to pay</p>
                                                                <img src="assets/images/gcash payment.jpg" alt="" height="500">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end Pay with Gcash box-->

                                                    <!-- Pay with proof box-->
                                                    <div class="border p-3 mb-3 rounded mx-auto">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <p class="mb-0 ps-3 pt-1">Upload your proof payment</p>
                                                                <form action="proof.php" method="post" enctype="multipart/form-data">
                                                                    <input type="file" name="proofFile" id="proofFile" accept=".jpg, .jpeg, .png" required>
                                                                    <div id="filePreview"></div> <!-- Container for the file preview -->
                                                                    <button type="submit">Submit</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end Pay with proof box-->


                                                </div> <!-- end col -->

                                                <div class="col-lg-4">
                                                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                                                        <h4 class="header-title mb-3">Order Summary</h4>

                                                        <div class="table-responsive">
                                                            
                                                            <table class="table table-centered mb-0">
                                                                <thead>
                                                                    <th>Product</th>
                                                                    <th>Name</th>
                                                                    <th>Price</th>
                                                                    <th>Quantity</th>
                                                                    <th>Total Price</th>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $select_cart = mysqli_query($conn, "SELECT * FROM `tb_cart` WHERE user_id = '$user_id'"); // Modify the query to include the user_id condition

                                                                    $grand_total = 0;

                                                                    if (mysqli_num_rows($select_cart) > 0) {
                                                                        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                                                    ?>
                                                                            <tr>
                                                                                <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                                                                                <td><?php echo $fetch_cart['name']; ?></td>
                                                                                <td>₱<?php echo number_format($fetch_cart['price']); ?></td>
                                                                                <td><?php echo $fetch_cart['quantity']; ?></td>
                                                                                <td><?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                                                                            </tr>
                                                                    <?php
                                                                            $grand_total += $sub_total;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <tr class="text-end">
                                                                        <td>
                                                                            <h5 class="m-2"> Grand Total:</h5>
                                                                        </td>
                                                                        <td>P<?php echo $grand_total; ?></td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- end table-responsive -->
                                                    </div> <!-- end .border-->

                                                </div> <!-- end row-->

                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                    </div>
                                    <!-- End Payment Information Content-->

                                </div> <!-- end tab content-->

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

            </div> <!-- container -->

        </div> <!-- content -->


        <!-- content -->

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © TEKUNO
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



    <!-- demo app -->
    <script src="assets/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <script>
        const proofFileInput = document.getElementById('proofFile');
        const filePreviewContainer = document.getElementById('filePreview');

        proofFileInput.addEventListener('change', function() {
            while (filePreviewContainer.firstChild) {
                filePreviewContainer.removeChild(filePreviewContainer.firstChild);
            }

            const files = this.files;
            for (const file of files) {
                const fileType = file.type.split('/')[0]; // Get the type of the file (image or pdf)

                if (fileType === 'image') {
                    const imagePreview = document.createElement('img');
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.style.maxWidth = '50%';
                    imagePreview.style.height = '80%';
                    filePreviewContainer.appendChild(imagePreview);
                } else if (fileType === 'application' && file.type === 'application/pdf') {
                    const pdfPreview = document.createElement('iframe');
                    pdfPreview.src = URL.createObjectURL(file);
                    pdfPreview.style.width = '100%';
                    pdfPreview.style.height = '300px'; // Adjust the height as needed
                    filePreviewContainer.appendChild(pdfPreview);
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Your existing JavaScript code for handling other functionalities here.
        });
    </script>
</body>
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

<script>
    $(document).ready(function() {
        var addressComplete = <?php echo $addressComplete ? 'true' : 'false'; ?>;
        var paymentButtonClicked = false;

        // Get the "Payment Information" tab link
        var paymentInfoTab = $('.nav-link[href="#payment-information"]');

        // Add an event listener to the "Continue to Payment" button
        $(".btn.btn-danger").click(function() {
            if (addressComplete) {
                // Show the "Payment Information" tab
                paymentInfoTab.tab('show');
            }
            paymentButtonClicked = true;
        });

        // Disable the "Payment Information" tab until the "Proceed to Payment" button is clicked and the address is complete
        if (!addressComplete || !paymentButtonClicked) {
            paymentInfoTab.addClass('disabled');
        }
    });
</script>





</html>