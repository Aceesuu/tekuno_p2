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
                                <a data-bs-toggle="collapse" href="#sidebarEcommerceOrder" aria-expanded="false" aria-controls="sidebarEcommerceOrder" class="side-nav-link">
                                    <i class=" uil-shopping-cart-alt"></i>
                                    <span> Order </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarEcommerceOrder">
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
                                    
                                    ?>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        
                        

                                        <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <?php
                                                    // Fetch the top 10 products from the tb_order table
                                                    $query = "SELECT name, SUM(qty) AS total_quantity, SUM(qty * price) AS total_amount FROM tb_order GROUP BY name ORDER BY total_quantity DESC LIMIT 5";
                                                    $result = $conn->query($query);
                                                    ?>
                                                    <h4 class="header-title mt-2 mb-3"> Top Selling Products <i class="mdi mdi-chart-timeline-variant-shimmer text-muted" style="font-size: 24px;"></i></h4>

                                                    <div class="table-responsive">
                                                        <table class="table table-centered table-nowrap table-hover mb-0">
                                                            <thead>
                                                                <tr>
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
                                        </div> <!-- end col--

                                    </div> <!-- end row -->
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
                        </div>
                        
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

                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Daily Sales</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT product_id, subtotal, order_date, 'Complete' AS order_status
                                                FROM tb_order
                                                WHERE order_status = 'Complete'
                                                UNION
                                                SELECT product_id, subtotal, order_date, 'Onsite' AS order_status
                                                FROM order_onsite
                                                ORDER BY order_date ASC";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Date', 'Sales');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["order_date"], (float) $row["subtotal"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Date'),
                                            'vAxis' => array('title' => 'Sales'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                var options = ' . json_encode($options) . ';

                                                var chart = new google.visualization.BarChart(document.getElementById("daily-sales"));
                                                chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="daily-sales"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Weekly Sales</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT
                                                    week_number,
                                                    SUM(subtotal) AS weekly_sales
                                                FROM (
                                                    SELECT
                                                        WEEK(order_date) AS week_number,
                                                        subtotal
                                                    FROM tb_order
                                                    WHERE order_status = 'Complete'
                                                    AND DATE_SUB(CURDATE(), INTERVAL 2 WEEK) <= order_date
                                                    UNION ALL
                                                    SELECT
                                                        WEEK(order_date) AS week_number,
                                                        subtotal
                                                    FROM order_onsite
                                                    WHERE DATE_SUB(CURDATE(), INTERVAL 2 WEEK) <= order_date
                                                ) AS combined_data
                                                GROUP BY week_number
                                                ORDER BY week_number";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Week', 'Sales');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["week_number"], (float) $row["weekly_sales"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Week'),
                                            'vAxis' => array('title' => 'Sales'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                var options = ' . json_encode($options) . ';

                                                var chart = new google.visualization.BarChart(document.getElementById("weekly-sales"));
                                                chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="weekly-sales"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Monthly Sales</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT
                                                    YEAR(order_date) AS year,
                                                    MONTHNAME(order_date) AS month,
                                                    SUM(price) AS monthly_sales
                                                FROM (
                                                    SELECT order_date, price
                                                    FROM tb_order
                                                    WHERE order_status = 'Complete'
                                                    UNION ALL
                                                    SELECT order_date, price
                                                    FROM order_onsite
                                                ) AS combined_data
                                                GROUP BY year, month
                                                ORDER BY year, month";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Month', 'Sales');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["month"], (float) $row["monthly_sales"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Month'),
                                            'vAxis' => array('title' => 'Sales'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                var options = ' . json_encode($options) . ';

                                                var chart = new google.visualization.BarChart(document.getElementById("monthly-sales"));
                                                chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="monthly-sales"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Daily Profit</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT o.product_id, 
                                                        o.price AS sale_price, 
                                                        p.supplier_price, 
                                                        (o.price - p.supplier_price) * o.qty AS profit, 
                                                        o.order_date
                                                FROM tb_order AS o
                                                        INNER JOIN tb_product AS p
                                                        ON o.product_id = p.product_id
                                                WHERE o.order_status = 'Complete'
                                                ORDER BY o.order_date ASC";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Date', 'Profit');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["order_date"], (float) $row["profit"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Date'),
                                            'vAxis' => array('title' => 'Profit'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                var options = ' . json_encode($options) . ';

                                                var chart = new google.visualization.BarChart(document.getElementById("daily-profit"));
                                                chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="daily-profit"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Weekly Profit</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT
                                                        YEARWEEK(o.order_date) AS week,
                                                        SUM(o.price - p.supplier_price) * SUM(o.qty) AS weekly_profit
                                                    FROM tb_order AS o
                                                    INNER JOIN tb_product AS p ON o.product_id = p.product_id
                                                    WHERE o.order_status = 'Complete'
                                                    GROUP BY week
                                                    ORDER BY week ASC";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Week', 'Profit');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["week"], (float) $row["weekly_profit"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Week'),
                                            'vAxis' => array('title' => 'Profit'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                var options = ' . json_encode($options) . ';

                                                var chart = new google.visualization.BarChart(document.getElementById("weekly-profit"));
                                                chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="weekly-profit"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Monthly Profit</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT
                                                        DATE_FORMAT(o.order_date, '%Y-%m') AS month,
                                                        SUM(o.price - p.supplier_price) * SUM(o.qty) AS monthly_profit
                                                    FROM tb_order AS o
                                                    INNER JOIN tb_product AS p ON o.product_id = p.product_id
                                                    WHERE o.order_status = 'Complete'
                                                    GROUP BY month
                                                    ORDER BY month ASC";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {

                                        $data = array();
                                        $data[] = array('Month', 'Sales');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["month"], (float) $row["monthly_profit"]);
                                        }

                                        $json_data = json_encode($data);

                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Month'),
                                            'vAxis' => array('title' => 'Sales'),
                                            'orientation' => 'horizontal',
                                        );

                                        $chart_html1 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                var options = ' . json_encode($options) . ';

                                                var chart = new google.visualization.BarChart(document.getElementById("monthly-profit"));
                                                chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo chart HTML and JavaScript
                                        echo '<div id="monthly-profit"></div>';
                                        echo $chart_html1;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Forecasting (Moving Average)</h4>

                                    <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "WITH MonthlySales AS (
                                            SELECT
                                                YEAR(order_date) AS year,
                                                MONTHNAME(order_date) AS month,
                                                SUM(price) AS monthly_sales
                                            FROM (
                                                SELECT order_date, price
                                                FROM tb_order
                                                WHERE order_status = 'Complete'
                                                UNION ALL
                                                SELECT order_date, price
                                                FROM order_onsite
                                            ) AS combined_data
                                            GROUP BY year, month
                                        )
                                        
                                        SELECT
                                            year,
                                            month,
                                            monthly_sales,
                                            -- Calculate 3-month Simple Moving Average
                                            ROUND(AVG(monthly_sales) OVER (ORDER BY year, month ROWS BETWEEN 2 PRECEDING AND CURRENT ROW), 2) AS moving_average,
                                            -- Data for the next month
                                            LEAD(monthly_sales) OVER (ORDER BY year, month) AS next_month_sales,
                                            -- Data for the next next month
                                            LEAD(monthly_sales, 2) OVER (ORDER BY year, month) AS next_next_month_sales
                                        FROM MonthlySales
                                        ORDER BY year ASC, month DESC;";

                                    $results = mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {
                                        $data = array();
                                        // Add a new array for moving average data
                                        $data[] = array('Date', 'Sales', 'Moving Average');

                                        while ($row = mysqli_fetch_assoc($results)) {
                                            $data[] = array($row["month"], (float) $row["monthly_sales"], (float) $row["moving_average"]);
                                        }

                                        // Encode data for both bar and line charts
                                        $json_data = json_encode($data);

                                        // Add options for both charts
                                        $options = array(
                                            'legend' => 'top',
                                            'chartArea' => array('width' => '70%', 'height' => '60%'),
                                            'hAxis' => array('title' => 'Date'),
                                            'vAxis' => array('title' => 'Sales'),
                                            'orientation' => 'horizontal',
                                            'series' => array(
                                                0 => array('type' => 'bars'), // Bar chart settings
                                                1 => array('type' => 'line', 'targetAxisIndex' => 1) // Line chart settings
                                            ),
                                            'axes' => array(
                                                1 => array('title' => 'Moving Average')
                                            )
                                        );

                                        // Draw both bar and line charts
                                        $chart_html = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                            <script type="text/javascript">
                                                google.charts.load("current", {"packages":["bar", "corechart"]});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {
                                                    var data = new google.visualization.arrayToDataTable(' . $json_data . ');

                                                    var options = ' . json_encode($options) . ';

                                                    var chart = new google.visualization.ComboChart(document.getElementById("moving-average"));
                                                    chart.draw(data, options);
                                                }
                                            </script>';

                                        // Echo combined chart HTML and JavaScript
                                        echo '<div id="moving-average"></div>';
                                        echo $chart_html;
                                    } else {
                                        echo "0 results";
                                    }

                                    mysqli_close($conn);
                                    ?>
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
            <script src="assets/js/vendor/apexcharts.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
            <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
            <!-- third party js ends -->

            <!-- demo app -->
            <script src="assets/js/pages/demo.dashboard.js"></script>
            <!-- end demo js-->
</body>

</html>