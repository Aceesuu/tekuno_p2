<?php
session_start(); // Start the session
include("mysql_connect.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM tb_admin WHERE admin_id = '$admin_id'";
$admin_result = mysqli_query($conn, $query);

if ($admin_result && mysqli_num_rows($admin_result) > 0) {
    $admin_data = mysqli_fetch_assoc($admin_result);
} else {
    $error_message = "Error: Unable to retrieve admin data or admin is not authorized.";
}

// Get the user_id from the URL parameter
$user_id = $_GET['user_id'];

// Ensure that $user_id is a valid integer
if (!is_numeric($user_id)) {
    // Handle invalid user_id (e.g., display an error message)
    die("Invalid user ID.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logoo.ico">

    <!-- Datatables css -->
    <link href="assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <link rel="stylesheet" href=" css/order.css">

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu" style="background-color: #212A37;">

            <!-- LOGO -->
            <a href="dashboard.php" class="logo text-center logo-light">
                <span class="logo-lg" style="background-color: #212A37;">
                    <img src="assets/images/logo.png" alt="" height="100">
                </span>
                <span class="logo-sm" style="background-color: #212A37;">
                    <img src="assets/images/logo.png" alt="" height="47">
                </span>
            </a>
            <br> <br>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>
                    <li class="side-nav-item">
                        <a href="dashboard.php" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <ul class="side-nav">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEcommerceProducts" aria-expanded="false" aria-controls="sidebarEcommerceProducts" class="side-nav-link">
                                <i class="uil-store"></i>
                                <span> Products </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarEcommerceProducts">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="products.php">List of Products</a>
                                    </li>
                                    <li>
                                        <a href="category.php">Product Category</a>
                                    </li>
                                    <li>
                                        <a href="manage_product.php">Manage Product</a>
                                    </li>
                                </ul>
                            </div>
                        </li>


                        <li class="side-nav-item">
                            <a href="inventory.php" class="side-nav-link">
                                <i class="uil-store"></i>
                                <span> Inventory </span>
                            </a>
                        </li>

                        <ul class="side-nav">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarEcommerceOrder" aria-expanded="false" aria-controls="sidebarEcommerceOrder" class="side-nav-link">
                                    <i class="mdi mdi-clipboard-list-outline"></i>
                                    <span> Order </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarEcommerceOrder">
                                    <ul class="side-nav-second-level">
                                        <li>
                                            <a href="order.php">Order Details</a>
                                        </li>
                                        <li>
                                            <a href="order_onsite.php">Order Onsites</a>
                                        </li>
                                        <li>
                                            <a href="order_history_admin.php">Order History</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="side-nav-item">
                                <a href="customers.php" class="side-nav-link">
                                    <i class="dripicons-user-group"></i>
                                    <span> Customers </span>
                                </a>
                            </li>
                            <li class="side-nav-item">
                                <a href="admins.php" class="side-nav-link">
                                    <i class="dripicons-user"></i>
                                    <span> Admins </span>
                                </a>
                            </li>
                            
  <li class="side-nav-item">
                        <a href="sales_report.php" class="side-nav-link">
                            <i class="dripicons-graph-pie"></i>
                            <span> Sales Report </span>
                        </a>
                    </li>
                            <!-- End Sidebar -->

                            <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <?php include('message.php'); ?>
        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                        <li class="dropdown notification-list d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-search noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                <form class="p-3">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="dripicons-bell noti-icon"></i>
                                <span class="noti-icon-badge"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

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
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <?php
                                    $user_image = $admin_data['image'];
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
                                    <span class="account-user-name"><?php echo $admin_data['firstName'] ?></span>
                                    <span class="account-position">Admin</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="profile_admin.php" class="dropdown-item notify-item">
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
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <div class="app-search dropdown d-none d-lg-block">
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                                <span class="mdi mdi-magnify search-icon"></span>
                                <button class="input-group-text btn-primary" type="submit">Search</button>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                        <h3 class="header-title mb-3" style="text-align: center;">Order Summary</h3>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0">
                                <tbody>
                                    <?php
                                    $select_products = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `user_id` = $user_id ORDER BY `order_id`");
                                    $prev_order_id = null; // Initialize the previous order ID variable

                                    if (mysqli_num_rows($select_products) > 0) {
                                        while ($row = mysqli_fetch_assoc($select_products)) {
                                            $current_order_id = $row['order_id'];

                                            // Check if the current order ID is different from the previous one
                                            if ($current_order_id != $prev_order_id) {
                                                // Close the previous table if it's not the first iteration
                                                if ($prev_order_id !== null) {
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                                                }

                                                // Display the unique order ID
                    ?>
                    <h4 class="header-title mb-3"> Order# <?php echo $current_order_id; ?> </h4>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Order Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                            }

                                            // Display the product details for the current order
                            ?>
                            <tr>
                                <td>
                                    <img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt="contact-img" title="contact-img" class="rounded me-2">
                                    <p class="m-0 d-inline-block align-middle">
                                        <a href="#" class="text-body fw-semibold"><?php echo $row['name']; ?></a>
                                        <br>
                                        <small><?php echo $row['qty']; ?> x <?php echo number_format($row['price']); ?></small>
                                    </p>
                                </td>
                                <td><?php echo $row['qty']; ?></td>
                                <td>₱<?php echo $row['price']; ?></td>
                                <td>₱<?php echo $row['qty'] * $row['price']; ?></td>
                                <td><?php echo $row['order_status']; ?></td>
                            </tr>
                        <?php

                                            // Update the previous order ID variable
                                            $prev_order_id = $current_order_id;
                                        }
                                    }

                                    // Close the last table if there are results
                                    if (mysqli_num_rows($select_products) > 0) {
                        ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                                    }
                ?>
                <!-- end row -->

                <!-- end row -->


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

        <!-- third party js -->
        <script src="assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="assets/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="assets/js/vendor/dataTables.responsive.min.js"></script>
        <script src="assets/js/vendor/responsive.bootstrap5.min.js"></script>

        <!-- Datatable Init js -->
        <script src="assets/js/pages/demo.datatable-init.js"></script>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-o6bLTM2BjR41l/6t1Sss/OtX4Yp1p2qE6neGJ0wMmR8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha256-YozT52Tvl6FsThQz3DlF6b6t8zVf3DzA/0H3A6EiPPE=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha384-Kay7B3Qj2TqpBMp7rN7R+JGzxp7F2bNQfDHxng5tQ8o66fwW0ueRdKp5l3kI33dM" crossorigin="anonymous"></script>

        <script>
            function exportToPDF() {
                // Open a new window or tab with the "pdf.php" URL
                window.open('pdf.php', '_blank');
            }
        </script>
        <script>
            function handleOrder(orderId, action) {
                $.ajax({
                    type: "POST",
                    url: "order_crud.php",
                    data: {
                        order_id: orderId,
                        action: action
                    },
                    success: function(response) {
                        // Handle the success response, e.g., refresh the order list
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function ToShip(orderId) {
                handleOrder(orderId, "toShip");
            }

            function ToReceive(orderId) {
                handleOrder(orderId, "toReceive");
            }

            function declineOrder(orderId) {
                handleOrder(orderId, "decline");
            }
        </script>

        <script>
            // Get references to the thumbnail and full-size image elements
            const thumbnail = document.querySelectorAll('.thumbnail');
            const fullImageContainer = document.getElementById('fullImageContainer');
            const fullImage = document.getElementById('fullImage');

            // Add click event listeners to each thumbnail
            thumbnail.forEach((thumb) => {
                thumb.addEventListener('click', (event) => {
                    const fullImagePath = event.target.getAttribute('data-full-image');

                    // Set the src attribute of the full-size image
                    fullImage.src = fullImagePath;

                    // Show the full-size image container
                    fullImageContainer.style.display = 'block';

                    // Prevent scrolling of the underlying page
                    document.body.style.overflow = 'hidden';
                });
            });

            // Add click event listener to close the full-size image
            fullImageContainer.addEventListener('click', () => {
                // Hide the full-size image container
                fullImageContainer.style.display = 'none';

                // Allow scrolling of the underlying page again
                document.body.style.overflow = 'auto';
            });
        </script>


</body>

</html>