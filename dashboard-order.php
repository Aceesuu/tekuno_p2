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

$sql_combined = "SELECT COUNT(DISTINCT order_id) AS order_count_combined FROM (SELECT order_id FROM tb_order 
                UNION SELECT order_id FROM order_onsite) AS combined_orders";
$result_combined = $conn->query($sql_combined);

if ($result_combined->num_rows > 0) {
    $row_combined = $result_combined->fetch_assoc();
    $order_count_combined = $row_combined["order_count_combined"];
} else {
    $order_count_combined = 0;
}

$sql = "SELECT COUNT(DISTINCT order_id) AS cancel_count FROM tb_order WHERE order_status = 'Cancelled'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cancel_count = $row["cancel_count"];
} else {
    $cancel_count = 0;
}

//refund
$sql = "SELECT COUNT(*) AS refund_count FROM tb_refund";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $refund_count = $row["refund_count"];
} else {
    $refund_count = 0;
}

// Count of orders with status "Pending"
$sql = "SELECT COUNT(DISTINCT order_id) AS pending_count FROM tb_order WHERE order_status = 'Pending'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pendingCount = $row["pending_count"];
} else {
    $pendingCount = 0;
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
    <!-- Include Chart.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

</head>

<body class="loading" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu" style="background-color: #212A37;">

            <!-- LOGO -->
            <a href="dashboard-order.php" class="logo text-center logo-light">
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
                        <a href="dashboard-order.php" class="side-nav-link">
                            <i class="dripicons-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <ul class="side-nav">
                        <ul class="side-nav">
                            <li class="side-nav-item">
                                <a href="#sidebarEcommerceOrder" aria-expanded="false" aria-controls="sidebarEcommerceOrder" class="side-nav-link">
                                    <i class="uil-shopping-cart-alt"></i>
                                    <span> Order </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="sidebarEcommerceOrder">
                                    <ul class="side-nav-second-level">
                                        <li>
                                            <a href="role_order.php">Order Details</a>
                                        </li>
                                        <li>
                                            <a href="role_order_onsite.php">Order Onsites</a>
                                        </li>
                                        <li>
                                            <a href="role_order_history.php">Order History</a>
                                        </li>
                                          <li>
                                            <a href="role_refund_admin.php">Request Refund</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>


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
                                    <span class="account-position">Order Manager</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="order_profile_admin.php" class="dropdown-item notify-item">
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
                                        <div class="col-sm-3 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $order_count_combined; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Overall Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $cancel_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Cancelled Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $refund_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Refund Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!-- end row -->
                                </div>
                            </div> <!-- end card-box-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                    <?php
                    // Query to retrieve data for order count
                    $sql_order_count = "SELECT 
                    (SELECT COUNT(DISTINCT order_id) FROM tb_order) AS online_orders,
                    (SELECT COUNT(DISTINCT order_id) FROM order_onsite) AS onsite_orders";
                    $result_order_count = $conn->query($sql_order_count);

                    // Query to retrieve data for total sales
                    $sql_sales = "SELECT 
                    (SELECT SUM(subtotal) FROM tb_order) AS online_sales,
                    (SELECT SUM(subtotal) FROM order_onsite) AS onsite_sales";
                    $result_sales = $conn->query($sql_sales);
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card widget-inline">
                                <div class="card-body p-0">
                                    <div class="row g-0">
                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0">
                                                <div class="card-body text-center">
                                                    <i class="mdi mdi-briefcase-clock" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $pendingCount; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Pending Orders</p>
                                                </div>
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
                                        <br><br> <br><br> <br><br> <br><br> <br>

                                        <!-- Order Count Pie Chart -->
                                        <div class="col-sm-6 col-xl-6">
                                            <?php
                                            if ($result_order_count) {
                                                // Define chart data array
                                                $data_order_count = array();
                                                $data_order_count[] = array('Order Type', 'Count');
                                                $row_order_count = $result_order_count->fetch_assoc();
                                                $data_order_count[] = array('Online Orders', (int) $row_order_count["online_orders"]);
                                                $data_order_count[] = array('On-site Orders', (int) $row_order_count["onsite_orders"]);

                                                // Encode chart data as JSON
                                                $json_data_order_count = json_encode($data_order_count);

                                                // Define chart options
                                                $options_order_count = array(
                                                    'title' => 'Online and Onsite Orders',
                                                    'legend' => 'right', // Display legend on the right
                                                    'chartArea' => array('width' => '80%', 'height' => '80%'),
                                                );

                                                // Define chart HTML and JavaScript for order count pie chart
                                                $chart_html_order_count = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                                <script type="text/javascript">
                                                    google.charts.load("current", {"packages":["corechart"]});
                                                    google.charts.setOnLoadCallback(drawOrderCountChart);

                                                    function drawOrderCountChart() {
                                                        var data = new google.visualization.arrayToDataTable(' . $json_data_order_count . ');

                                                        var options = ' . json_encode($options_order_count) . ';

                                                        var chart = new google.visualization.PieChart(document.getElementById("order-count-chart"));
                                                        chart.draw(data, options);
                                                    }
                                                </script>';

                                                // Echo order count chart HTML and JavaScript
                                                echo '<div id="order-count-chart"></div>';
                                                echo $chart_html_order_count;
                                            } else {
                                                echo "0 results for order count";
                                            }

                                            // Step 4: Close the order count result set
                                            $result_order_count->close();
                                            ?>
                                        </div>

                                        <!-- Total Sales Bar Chart -->
                                        <div class="col-sm-6 col-xl-6">
                                            <?php
                                            if ($result_sales) {
                                                // Define chart data array
                                                $data_sales = array();
                                                $data_sales[] = array('Sales Type', 'Total Sales', array('role' => 'style'));
                                                $row_sales = $result_sales->fetch_assoc();
                                                $data_sales[] = array('Online Sales', (float) $row_sales["online_sales"], '#3366cc');
                                                $data_sales[] = array('On-site Sales', (float) $row_sales["onsite_sales"], '#dc3912');

                                                // Encode chart data as JSON
                                                $json_data_sales = json_encode($data_sales);

                                                // Define chart options
                                                $options_sales = array(
                                                    'title' => 'Total Sales: Online vs On-site Sales',
                                                    'legend' => 'none', // Hide legend for simplicity
                                                    'chartArea' => array('width' => '80%', 'height' => '80%'),
                                                    'bars' => 'horizontal', // Display horizontal bars
                                                    'hAxis' => array('title' => 'Total Sales'),
                                                );

                                                // Define chart HTML and JavaScript for total sales bar chart
                                                $chart_html_sales = '<script type="text/javascript">
                                                google.charts.setOnLoadCallback(drawSalesChart);

                                                function drawSalesChart() {
                                                    var data = new google.visualization.arrayToDataTable(' . $json_data_sales . ');

                                                    var options = ' . json_encode($options_sales) . ';

                                                    var chart = new google.visualization.BarChart(document.getElementById("sales-chart"));
                                                    chart.draw(data, options);
                                                }
                                            </script>';

                                                // Echo total sales chart HTML and JavaScript
                                                echo '<div id="sales-chart"></div>';
                                                echo $chart_html_sales;
                                            } else {
                                                echo "0 results for total sales";
                                            }

                                            // Step 6: Close the total sales result set
                                            $result_sales->close();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>








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
            <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>

            <!-- demo:js -->
            <!-- demo end -->
            <!-- third party js ends -->
            <script>
                $(document).ready(function() {
                    // Initialize datepicker
                    $('#datePicker').datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true
                    });

                    // Listen for changes in the datepicker value
                    $('#datePicker').on('changeDate', function() {
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