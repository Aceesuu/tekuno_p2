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


// SQL query to count the orders
$sql = "SELECT COUNT(DISTINCT order_id) AS order_count FROM tb_order";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $order_count = $row["order_count"];
} else {
    $order_count = 0;
}


$sql = "SELECT COUNT(*) AS customer_count FROM tb_user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $customerCount = $row["customer_count"];
} else {
    $customerCount = 0;
}

$sql = "SELECT COUNT(*) AS admin_count FROM tb_admin";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $admin_count = $row["admin_count"];
} else {
    $admin_count = 0;
}

$conn->close();
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
            <a href="dashboard.php" class="logo text-center logo-light">
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
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <li class="side-nav-item">
                            <a href="customers.php" class="side-nav-link">
                                <i class="uil-users-alt"></i>
                                <span> Customers </span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="admins.php" class="side-nav-link">
                                <i class="uil-user-check"></i>
                                <span> Admins </span>
                            </a>
                        </li>

                        <li class="side-nav-item">
                            <a href="forecast.php" class="side-nav-link">
                                <i class="uil-chart"></i>
                                <span> Forecast </span>
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
                                    <span class="account-position">Admin/Cashier</span>
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
                                                    <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $customerCount; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Customer</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $order_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Orders</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $admin_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Admin</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i>
                                                    <h3><span>
                                                            <?php
                                                            if ($order_count > 0) {
                                                                $percentage = min(100, round(($customerCount / $order_count) * 100));
                                                                echo $percentage . "%";
                                                            } else {
                                                                echo "No orders";
                                                            }
                                                            ?>
                                                        </span>
                                                        <i class="mdi mdi-arrow-up text-success"></i>
                                                    </h3>
                                                    <p class="text-muted font-15 mb-0">Sales</p>
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
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Order Sales</h4>

                                    <div id="sessions-browser" class="apex-charts mt-3" data-colors="#727cf5"></div>
                                    <?php
                                    include("mysql_connect.php");
                                    $querychart = "SELECT name, price FROM tb_order";
                                    $query_result = mysqli_query($conn, $querychart);
                                    $data = array();
                                    while ($row = mysqli_fetch_assoc($query_result)) {
                                        $data[] = $row;
                                    }

                                    $labels = array();
                                    $values = array();
                                    foreach ($data as $row) {
                                        $labels[] = $row['name'];
                                        $values[] = $row['price'];
                                    }

                                    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

                                    echo '<canvas id="myChart"></canvas>';
                                    echo '<script>';
                                    echo 'var ctx = document.getElementById("myChart").getContext("2d");';
                                    echo 'var myChart = new Chart(ctx, {';
                                    echo '    type: "bar",';
                                    echo '    data: {';
                                    echo '        labels: ' . json_encode($labels) . ',';
                                    echo '        datasets: [{';
                                    echo '            label: "TOTAL AMOUNT",';
                                    echo '            data: ' . json_encode($values) . ',';
                                    echo '            backgroundColor: "rgba(255, 99, 132, 0.2)",';
                                    echo '            borderColor: "rgba(255, 99, 132, 1)",';
                                    echo '            borderWidth: 1';
                                    echo '        }]';
                                    echo '    },';
                                    echo '    options: {';
                                    echo '        scales: {';
                                    echo '            yAxes: [{';
                                    echo '                ticks: {';
                                    echo '                    beginAtZero: true';
                                    echo '                }';
                                    echo '            }]';
                                    echo '        }';
                                    echo '    }';
                                    echo '});';
                                    echo '</script>';
                                    ?>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Order Sales Percentage</h4>

                                    <div id="sessions-browser" class="apex-charts mt-3" data-colors="#727cf5"></div>
                                    <?php

                                    // Query to retrieve data from your database
                                    $sql = "SELECT name, price FROM tb_order";
                                    $result = mysqli_query($conn, $sql);

                                    // Step 3: Create and display the chart
                                    if (mysqli_num_rows($result) > 0) {
                                        // Define chart data array
                                        $data = array();
                                        $data[] = array('Name', 'Price');

                                        // Loop through query results and add data to chart data array
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $data[] = array($row["name"], (float) $row["price"]); // Assuming 'price' is a numeric value
                                        }

                                        // Encode chart data as JSON
                                        $json_data = json_encode($data);

                                        // Define chart options
                                        $options = array(
                                            'title' => 'Order Prices by Name',
                                            'legend' => 'right', // Display legend on the right
                                            'chartArea' => array('width' => '80%', 'height' => '80%'),
                                        );

                                        // Define chart HTML and JavaScript
                                        $chart_html = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                          <script type="text/javascript">
                                            google.charts.load("current", {"packages":["corechart"]});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                              var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                              var options = ' . json_encode($options) . ';

                                              var chart = new google.visualization.PieChart(document.getElementById("chart_div"));
                                              chart.draw(data, options);
                                            }
                                          </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="chart_div"></div>';
                                        echo $chart_html;
                                    } else {
                                        echo "0 results";
                                    }

                                    // Step 4: Close the database connection
                                    mysqli_close($conn);
                                    ?>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="header-title">Total Stock Level</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT name, qty FROM tb_product";
                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Product Name', 'Quantity');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["name"], (float) $row["qty"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Product Name'),
                                            'vAxis' => array('title' => 'Quantity'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                          <script type="text/javascript">
                                            google.charts.load("current", {"packages":["corechart"]});
                                            google.charts.setOnLoadCallback(drawChart);

                                            function drawChart() {
                                              var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                              var options = ' . json_encode($options) . ';

                                              var chart = new google.visualization.BarChart(document.getElementById("chart_div1"));
                                              chart.draw(data, options);
                                            }
                                          </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="chart_div1"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
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
            <script src="assets/js/vendor/apexcharts.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
            <!-- third party js ends -->

            <!-- demo app -->
            <script src="assets/js/pages/demo.dashboard.js"></script>
            <!-- end demo js-->
</body>

</html>