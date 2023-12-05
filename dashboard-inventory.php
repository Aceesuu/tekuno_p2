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

    // Log the action to the audit trail
    $action = "Access to Dashboard";
    logAction($conn, $admin_id, $admin_data['role'], $action);
} else {
    $error_message = "Error: Unable to retrieve admin data or admin is not authorized.";
}

// Function to log actions to the audit trail
function logAction($conn, $admin_id, $role, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $role = mysqli_real_escape_string($conn, $role);
    $query = "INSERT INTO audit_trail (admin_id, role, action) VALUES ('$admin_id', '$role', '$action')";
    mysqli_query($conn, $query);
}

$sql = "SELECT COUNT(DISTINCT product_id) AS instock_count FROM tb_product WHERE stock = 'Instock'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $instock_count = $row["instock_count"];
} else {
    $instock_count = 0;
}

$sql = "SELECT COUNT(DISTINCT product_id) AS outstock_count FROM tb_product WHERE stock = 'Out of Stock'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $outstock_count = $row["outstock_count"];
} else {
    $outstock_count = 0;
}


$sql = "SELECT COUNT(*) AS product_count FROM tb_product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_count = $row["product_count"];
} else {
    $product_count = 0;
}

$sql = "SELECT COUNT(*) AS category_count FROM tb_category";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $category_count = $row["category_count"];
} else {
    $category_count = 0;
}

$sql = "SELECT COUNT(DISTINCT variation_id) AS varianion_count FROM product_variation";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $varianion_count = $row["varianion_count"];
} else {
    $varianion_count = 0;
}

// Count of orders with status "To Ship"
$sql = "SELECT COUNT(DISTINCT order_id) AS to_ship_count FROM tb_order WHERE order_status = 'To Ship'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $toShipCount = $row["to_ship_count"];
} else {
    $toShipCount = 0;
}

// Count of orders with status "To Receive"
$sql = "SELECT COUNT(DISTINCT order_id) AS to_receive_count FROM tb_order WHERE order_status = 'To Receive'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $toReceiveCount = $row["to_receive_count"];
} else {
    $toReceiveCount = 0;
}

// Count of orders with status "Complete"
$sql = "SELECT COUNT(DISTINCT order_id) AS complete_count FROM tb_order WHERE order_status = 'Complete'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $completeCount = $row["complete_count"];
} else {
    $completeCount = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logoo.ico">

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
            <a href="dashboard-inventory.php" class="logo text-center logo-light">
                <span class="logo-lg" style="background-color: #212A37;">
                    <img src="assets/images/logo.png" alt="" height="100">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo.png" alt="" height="47">
                </span>
            </a>
            <br> <br>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">
                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>
                    <li class="side-nav-item">
                        <a href="dashboard-inventory.php" class="side-nav-link">
                            <i class="dripicons-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <ul class="side-nav">
                        <li class="side-nav-item">
                            <a  href="#sidebarEcommerceProducts" aria-expanded="false" aria-controls="sidebarEcommerceProducts" class="side-nav-link">
                                <i class="mdi mdi-clipboard-text-multiple-outline"></i>
                                <span> Products </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse show" id="sidebarEcommerceProducts">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="role_products.php">List of Products</a>
                                    </li>
                                    <li>
                                        <a href="role_category.php">Product Category</a>
                                    </li>
                                    <li>
                                        <a href="role_manage_products.php">Manage Product</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="side-nav-item">
                            <a href="role_inventory.php" class="side-nav-link">
                                <i class="mdi mdi-clipboard-list-outline"></i>
                                <span> Inventory </span>
                            </a>
                        </li>

                        <div class="clearfix"></div>
                    </ul>
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
                        </li>

                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">


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
                                    <span class="account-position">Inventory Manager</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- items-->
                                <a href="inventory_profile_admin.php" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="logout_admin.php" class="dropdown-item notify-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <form class="d-flex">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="mdi mdi-calendar-range font-13"></i>
                                            </span>
                                        </div>
                                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                            <i class="mdi mdi-autorenew"></i>
                                        </a>
                                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                                            <i class="mdi mdi-filter-variant"></i>
                                        </a>
                                    </form>
                                </div>
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card widget-inline">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                         <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0">
                                                <div class="card-body text-center">
                                                    <i class="uil-suitcase-alt" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $product_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Total Number of Products</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-label-multiple-outline" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $category_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Total Number of Categories</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                         <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-trending-up" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $instock_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Product Instock</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-trending-down" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $outstock_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0"> Out of Stock Product</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>
                            </div> <!-- end card-box-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->
                    <div class="row">
                        <div class="col-12">
                            <div class="card widget-inline">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col-sm-6 col-xl-3">
                                           <div class="card-body text-center">
                                                    <i class=" uil-pricetag-alt" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $varianion_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Total Products with Variations</p>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-cart-arrow-up" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $toShipCount; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">To Ship Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-account-clock-outline" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $toReceiveCount; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">To Receive Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-briefcase-check" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $completeCount; ?> </span>
                                                    </h3>
                                                    <p class="text-muted font-15 mb-0">Completed Orders</p>
                                                </div>
                                            </div>
                                        </div>
                        
                        

                                        </div> <!-- end col-->
                                </div> <!-- end row -->
                            </div>
                        </div> <!-- end card-box-->
                    </div> <!-- end col-->
                </div>
                <center>
                    <div class="col-xl-12 col-lg-12 order-lg-2 order-xl-2">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                // Fetch the top 10 products from the tb_order table
                                $query = "SELECT name, SUM(qty) AS total_quantity, SUM(qty * price) AS total_amount, image FROM tb_order GROUP BY name ORDER BY total_quantity DESC LIMIT 5";
                                $result = $conn->query($query);
                                ?>
                                <h4 class="header-title mt-2 mb-3"> Top Selling Products <i class="mdi mdi-chart-timeline-variant-shimmer text-muted" style="font-size: 24px;"></i></h4>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th></th>
                                                <th>Product Name</th>
                                                <th>Sold Quantity</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) :
                                                while ($row = $result->fetch_assoc()) : ?>
                                                    <tr>
                                                        <td><img src="uploaded_img/<?= $row['image'] ?>" alt="Image" height="100"></td>
                                                        <td><?= $row['name'] ?></td>
                                                        <td><?= $row['total_quantity'] ?></td>
                                                        <td><?= $row['total_amount'] ?></td>
                                                    </tr>
                                                <?php endwhile;
                                            else : ?>
                                                <tr>
                                                    <td colspan='3'>No data found</td>
                                                </tr>
                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </center>
                
   

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

            <!-- third party js -->
            <script src="assets/js/vendor/apexcharts.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
            <!-- third party js ends -->

            <!-- demo app -->
            <script src="assets/js/pages/demo.dashboard.js"></script>
            <!-- end demo js-->
            
               <script>
            $(document).ready(function(){
                // Initialize datepicker
                $('#datePicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                });

                // Listen for changes in the datepicker value
                $('#datePicker').on('changeDate', function(){
                    // Update the global variables with selected dates
                    <?php echo "startDate = $('#datePicker').val();"; ?>
                    <?php echo "endDate = $('#datePicker').val();"; ?>

                    // Reload or update your charts with the new date range
                    // ...
                });
            });
        </script>
        
</body>

</html>