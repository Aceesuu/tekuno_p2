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

// Check if the 'product_id' query parameter is present in the URL
if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch the product details from the database based on the product_id
    $query = "SELECT * FROM `tb_product` WHERE `product_id` = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $product = mysqli_fetch_assoc($result);
        // Now, $product variable contains all the details of the selected product
    } else {
        // If the product_id doesn't match any product, handle the error or redirect to a 404 page
        echo "Product not found.";
        // You can add more error-handling logic here if needed.
        exit;
    }
} else {
    // If the 'product_id' query parameter is not present or invalid, handle the error or redirect to a 404 page
    echo "Invalid product ID.";
    // You can add more error-handling logic here if needed.
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>View Products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

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
                            <i class="dripicons-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <ul class="side-nav">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEcommerceProducts" aria-expanded="false" aria-controls="sidebarEcommerceProducts" class="side-nav-link">
                                <i class="mdi mdi-clipboard-text-multiple-outline"></i>
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
                                <i class="mdi mdi-clipboard-list-outline"></i>
                                <span> Inventory </span>
                            </a>
                        </li>

                        <ul class="side-nav">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarEcommerceOrder" aria-expanded="false" aria-controls="sidebarEcommerceOrder" class="side-nav-link">
                                    <i class=" uil-shopping-cart-alt"></i>
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
                                        <li>
                                            <a href="refund_admin.php">Request Refund</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        
                                <ul class="side-nav">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarSales" aria-expanded="false" aria-controls="sidebarSales" class="side-nav-link">
                                <i class=" dripicons-graph-pie"></i>
                                <span> Sales </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarSales">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="sales_report.php">Sales Report</a>
                                    </li>
                                    <li>
                                        <a href="sales_filter.php">Sales Filter</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    
                     <ul class="side-nav">
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarProfit" aria-expanded="false" aria-controls="sidebarProfit" class="side-nav-link">
                                <i class=" uil-money-insert"></i>
                                <span> Profit </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarProfit">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="profit_report.php">Profit Report</a>
                                    </li>
                                    <li>
                                        <a href="profit_filter.php">Profit Filter</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                       <ul class="side-nav">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarCustomer" aria-expanded="false" aria-controls="sidebarCustomer" class="side-nav-link">
                                    <i class="uil-users-alt"></i>
                                    <span> Customer </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarCustomer">
                                    <ul class="side-nav-second-level">
                                        <li>
                                            <a href="customers.php">List of Customers</a>
                                        </li>
                                        <li>
                                            <a href="feedback.php">Customer Concerns</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        
                        <li class="side-nav-item">
                            <a href="admins.php" class="side-nav-link">
                                <i class="uil-user-check"></i>
                                <span> Admins </span>
                            </a>
                        </li>

                        <ul class="side-nav">
                            <li class="side-nav-item">
                                <a data-bs-toggle="collapse" href="#sidebarAudit" aria-expanded="false" aria-controls="sidebarAudit" class="side-nav-link">
                                    <i class=" mdi mdi-file-document-edit-outline"></i>
                                    <span> Audit Trail </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarAudit">
                                    <ul class="side-nav-second-level">
                                        <li>
                                            <a href="admin_logs.php">Admin Logs</a>
                                        </li>
                                        <li>
                                            <a href="user_logs.php">User Logs</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                    <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

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

                                <div style="max-height: 230px;" data-simplebar="">



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
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Settings</span>
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

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
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
                                            <a href="javascript:history.back()"><i class="dripicons-chevron-left"></i>Back</a>
                                            <!-- Product image -->
                                            <a href="#" class="text-center d-block mb-4">
                                                <img src="uploaded_img/<?php echo $product['image']; ?>" alt="Product-img" class="img-fluid" style="max-width: 280px;">
                                            </a>
                                        </div> <!-- end col -->
                                        <div class="col-lg-7">
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
                                            <h5><span>Stocks:</span>&nbsp;<?php echo $product['qty']; ?></h5>
                                            </p>

                                            <!-- Product description -->
                                            <div class="mt-4">
                                                <h6 class="font-14">Price:</h6>
                                                <h3> ₱<?php echo $product['price']; ?></h3>
                                            </div>

                                            <!-- Quantity -->
                                            <div class="mt-4">
                                                <h6 class="font-14">Quantity</h6>
                                                <div class="d-flex">
                                                    <?php echo $product['qty']; ?>
                                                </div>
                                            </div>

                                            <!-- Product description -->
                                            <div class="mt-4">
                                                <h6 class="font-14">Description:</h6>
                                                <p><?php echo $product['prod_desc']; ?></p>
                                            </div>

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

    <!-- third party js -->
    <script src="assets/js/vendor/apexcharts.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="assets/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->
</body>

</html>