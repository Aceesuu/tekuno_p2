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
$sql = "SELECT COUNT(DISTINCT id) AS concern_count FROM contacts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $concern_count = $row["concern_count"];
} else {
    $concern_count = 0;
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

$sql = "SELECT COUNT(*) AS male_count FROM tb_user WHERE gender = 'male'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maleCount = $row["male_count"];
} else {
    $maleCount = 0;
}

$sql = "SELECT COUNT(*) AS female_count FROM tb_user WHERE gender = 'female'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $femaleCount = $row["female_count"];
} else {
    $femaleCount = 0;
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
            <a href="dashboard-role-customer.php" class="logo text-center logo-light">
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
                        <a href="dashboard-role-customer.php" class="side-nav-link">
                            <i class="dripicons-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <ul class="side-nav">
                            <li class="side-nav-item">
                                <a  href="#sidebarCustomer" aria-expanded="false" aria-controls="sidebarCustomer" class="side-nav-link">
                                    <i class="uil-users-alt"></i>
                                    <span> Customer </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="sidebarCustomer">
                                    <ul class="side-nav-second-level">
                                        <li>
                                            <a href="role_customers.php">List of Customers</a>
                                        </li>
                                        <li>
                                            <a href="role_feedback.php">Customer Concerns</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                    <ul class="side-nav">
                            <li class="side-nav-item">
                                <a  href="#sidebarAudit" aria-expanded="false" aria-controls="sidebarAudit" class="side-nav-link">
                                    <i class=" mdi mdi-file-document-edit-outline"></i>
                                    <span> Audit Trail </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="sidebarAudit">
                                    <ul class="side-nav-second-level">
                                        <li>
                                            <a href="userlogs_role.php">User Logs</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
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
                                    <span class="account-position">Customer Management</span>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="customer_profile_admin.php" class="dropdown-item notify-item">
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
                                                    <p class="text-muted font-15 mb-0">Customers</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $concern_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Customer Concerns</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $maleCount; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Male Customers</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xl-3">
                                            <div class="card shadow-none m-0 border-start">
                                                <div class="card-body text-center">
                                                    <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $femaleCount; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Female Customers</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end row -->
                                </div>
                            </div> <!-- end card-box-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <?php
                        // Assuming $conn is your database connection
                        $query = "SELECT u.user_id, CONCAT(u.firstName, ' ', u.lastName) AS name, u.image, COUNT(o.order_id) AS total_order
                FROM tb_user u
                JOIN tb_order o ON u.user_id = o.user_id
                GROUP BY u.user_id
                ORDER BY total_order DESC
                LIMIT 5";

                        $result = $conn->query($query);
                        ?>

                        <h4 class="header-title text-center mt-2 mb-3">Top 5 Customers <i class="mdi mdi-chart-timeline-variant-shimmer text-muted" style="font-size: 24px;"></i></h4>
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Total Orders</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) :
                                        while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><img src="uploaded_img/<?= $row['image'] ?>" alt="Image" height="100"></td>
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['total_order'] ?></td>
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
                    </div>

                    <div class="col-xl-6 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Gender</h4>
                                <div id="sessions-browser" class="apex-charts mt-3" data-colors="#727cf5"></div>
                                <?php

                                // Query to retrieve data from your database
                                $sql = "SELECT gender, COUNT(*) as count FROM tb_user GROUP BY gender";
                                $result = mysqli_query($conn, $sql);

                                // Step 3: Create and display the chart
                                if (mysqli_num_rows($result) > 0) {
                                    // Define chart data array
                                    $data = array();
                                    $data[] = array('Gender', 'Count');

                                    // Loop through query results and add data to chart data array
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $data[] = array($row["gender"], (int) $row["count"]);
                                    }

                                    // Encode chart data as JSON
                                    $json_data = json_encode($data);

                                    // Define chart options
                                    $options = array(
                                        'title' => 'User Gender Distribution',
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
    <script src="assets/js/vendor/apexcharts.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <!-- third party js ends -->

    <!-- demo app -->
    <script src="assets/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->

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