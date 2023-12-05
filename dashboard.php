<?php
session_start(); // Start the session
include("mysql_connect.php");

// Function to log actions to the audit trail
function logAction($conn, $admin_id, $role, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $role = mysqli_real_escape_string($conn, $role);
    $query = "INSERT INTO audit_trail (admin_id, role, action) VALUES ('$admin_id', '$role', '$action')";
    mysqli_query($conn, $query);
}

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

// SQL query to count the orders
$sql = "SELECT COUNT(*) AS order_count FROM (SELECT DISTINCT order_id FROM tb_order) AS unique_orders";
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

//DATE FILTERING
$startDate = date('Y-m-d'); // Set your desired start date
$endDate = date('Y-m-d');   // Set your desired end date

// Function to create the date filter SQL condition
function getDateFilterCondition($column, $startDate, $endDate) {
    return "$column BETWEEN '$startDate' AND '$endDate'";
}

if (isset($_POST['filter'])) {
    // Retrieve the selected dates from the form
    $startDate = $_POST['from_date'];
    $endDate = $_POST['to_date'];

    function fetchDailySales($conn, $startDate, $endDate) {
        try {
            $sqlquery = "SELECT product_id, subtotal, order_date, 'Complete' AS order_status
                            FROM tb_order
                            WHERE order_status = 'Complete' AND " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                            UNION
                            SELECT product_id, subtotal, order_date, 'Onsite' AS order_status
                            FROM order_onsite
                            WHERE " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                            ORDER BY order_date ASC";
    
            $data = $conn->query($sqlquery);

            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function fetchWeeklySales($conn, $startDate, $endDate) {
        try {
            $sqlquery = "SELECT
                            week_number,
                            SUM(subtotal) AS weekly_sales
                        FROM (
                            SELECT
                                WEEK(order_date) AS week_number,
                                subtotal
                            FROM tb_order
                            WHERE order_status = 'Complete'
                            AND " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                            UNION ALL
                            SELECT
                                WEEK(order_date) AS week_number,
                                subtotal
                            FROM order_onsite
                            WHERE " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                        ) AS combined_data
                        GROUP BY week_number
                        ORDER BY week_number";
    
            $data = $conn->query($sqlquery);

            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function fetchMonthlySales($conn, $startDate, $endDate) {
        try {
            $sqlquery = "SELECT
                            YEAR(order_date) AS year,
                            MONTHNAME(order_date) AS month,
                            SUM(price) AS monthly_sales
                        FROM (
                            SELECT order_date, price
                            FROM tb_order
                            WHERE order_status = 'Complete' AND " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                            UNION ALL
                            SELECT order_date, price
                            FROM order_onsite
                            WHERE " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                        ) AS combined_data
                        GROUP BY year, month
                        ORDER BY year, month";
    
            $data = $conn->query($sqlquery);

            return $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function fetchDailyProfit($conn, $startDate, $endDate) {
        try {
            $sqlquery = "SELECT o.product_id, 
                                o.price AS sale_price, 
                                p.supplier_price, 
                                (o.price - p.supplier_price) * o.qty AS profit, 
                                o.order_date
                        FROM tb_order AS o
                        INNER JOIN tb_product AS p ON o.product_id = p.product_id
                        WHERE o.order_status = 'Complete' AND " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                        ORDER BY o.order_date ASC";
    
            $result = $conn->query($sqlquery);

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function fetchWeeklyProfit($conn, $startDate, $endDate) {
        try {
            $sqlquery = "SELECT YEARWEEK(o.order_date) AS week,
                                SUM(o.price - p.supplier_price) * SUM(o.qty) AS weekly_profit
                        FROM tb_order AS o
                        INNER JOIN tb_product AS p ON o.product_id = p.product_id
                        WHERE o.order_status = 'Complete' AND " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                        GROUP BY week
                        ORDER BY week ASC";
    
            $result = $conn->query($sqlquery);

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    function fetchMonthlyProfit($conn, $startDate, $endDate) {
        try {
            $sqlquery = "SELECT DATE_FORMAT(o.order_date, '%Y-%m') AS month,
                                SUM(o.price - p.supplier_price) * SUM(o.qty) AS monthly_profit
                        FROM tb_order AS o
                        INNER JOIN tb_product AS p ON o.product_id = p.product_id
                        WHERE o.order_status = 'Complete' AND " . getDateFilterCondition('order_date', $startDate, $endDate) . "
                        GROUP BY month
                        ORDER BY month ASC";
    
            $result = $conn->query($sqlquery);

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Call the function to fetch data with date filter
    $filteredDailySales = fetchDailySales($conn, $startDate, $endDate);
    $filteredWeeklySales = fetchWeeklySales($conn, $startDate, $endDate);
    $filteredMonthlySales = fetchMonthlySales($conn, $startDate, $endDate);

    $filteredDailyProfit = fetchDailyProfit($conn, $startDate, $endDate);
    $filteredWeeklyProfit = fetchWeeklyProfit($conn, $startDate, $endDate);
    $filteredMonthlyProfit = fetchMonthlyProfit($conn, $startDate, $endDate);

}

function filter($conn)
{
    try {
        $fromSelectedMonth = filter_input(INPUT_POST, 'from_selected_month', FILTER_VALIDATE_INT);
        $fromSelectedYear = filter_input(INPUT_POST, 'from_selected_year', FILTER_VALIDATE_INT);
        $toSelectedMonth = filter_input(INPUT_POST, 'to_selected_month', FILTER_VALIDATE_INT);
        $toSelectedYear = filter_input(INPUT_POST, 'to_selected_year', FILTER_VALIDATE_INT);

        if (
            $fromSelectedMonth === false || $fromSelectedYear === false ||
            $toSelectedMonth === false || $toSelectedYear === false
        ) {
            // Handle invalid input
            return false;
        }

        // Use prepared statement to prevent SQL injection
        $sqlquery = "SELECT * FROM moving_average_tbl WHERE MONTH(date_column) BETWEEN ? AND ? AND YEAR(date_column) BETWEEN ? AND ?";
        $stmt = $conn->prepare($sqlquery);
        $stmt->bind_param("iiii", $fromSelectedMonth, $toSelectedMonth, $fromSelectedYear, $toSelectedYear);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false; // or you can return an empty result set depending on your needs
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
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
                                                    <i class="mdi mdi-cash-refund" style="font-size: 24px;"></i>
                                                    <h3><span><?php echo $refund_count; ?></span></h3>
                                                    <p class="text-muted font-15 mb-0">Refunds</p>
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

                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="dateRangePicker">From:</label>
                            <div class="input-daterange input-group" id="dateRangePicker">
                                <input type="date" id="startDate" class="form-control" name="from_date" placeholder="From" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="dateRangePicker">To:</label>
                            <div class="input-daterange input-group" id="dateRangePicker">
                                <input type="date" id="endDate" class="form-control" name="to_date" placeholder="From" value="<?php echo isset($_POST['to_date']) ? $_POST['to_date'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="submit" name="filter" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Daily Sales</h4>

                                <?php

                                $sqlquery = "SELECT product_id, subtotal, order_date, 'Complete' AS order_status
                                                FROM tb_order
                                                WHERE order_status = 'Complete'
                                                UNION
                                                SELECT product_id, subtotal, order_date, 'Onsite' AS order_status
                                                FROM order_onsite
                                                ORDER BY order_date ASC";

                                $results = isset($filteredDailySales) ? $filteredDailySales : mysqli_query($conn, $sqlquery);

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

                                    $chart_html2 = '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                                    echo $chart_html2;
                                } else {
                                    echo "0 results";
                                }

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

                                $results = isset($filteredWeeklySales) ? $filteredWeeklySales : mysqli_query($conn, $sqlquery);

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

                                $results = isset($filteredMonthlySales) ? $filteredMonthlySales : mysqli_query($conn, $sqlquery); 

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

                                $results = isset($filteredDailyProfit) ? $filteredDailyProfit : mysqli_query($conn, $sqlquery);

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

                                $results = isset($filteredWeeklyProfit) ? $filteredWeeklyProfit : mysqli_query($conn, $sqlquery);

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

                                $results = isset($filteredMonthlyProfit) ? $filteredMonthlyProfit : mysqli_query($conn, $sqlquery);

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

            <form action="" method="post">
                <div class="row">
                    <label for="monthPicker" class="form-label">FROM</label>
                    <div class="col-md-6">
                        <label for="monthPicker" class="form-label">Select Month:</label>
                        <select id="monthPicker" class="form-select" name="from_selected_month" required>
                        <option value="" disabled selected>Select Month</option>
                        <?php
                            for ($i = 1; $i <= 12; $i++) {
                                $month = date('F', mktime(0, 0, 0, $i, 1));
                                $selected = isset($_POST['from_selected_month']) && $_POST['from_selected_month'] == $i ? 'selected' : '';
                                echo "<option value='$i'>$month</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="yearPicker" class="form-label">Select Year:</label>
                        <select id="yearPicker" class="form-select" name="from_selected_year" required>
                        <option value="" disabled selected>Select Year</option>
                        <?php
                            $currentYear = date('Y');
                            $selected = isset($_POST['from_selected_year']) && $_POST['from_selected_year'] == $year ? 'selected' : '';
                            for ($year = $currentYear + 1; $year >= $currentYear - 10; $year--) {
                                echo "<option value='$year'>$year</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <label for="monthPicker" class="form-label">TO</label>
                    <div class="col-md-6">
                        <label for="monthPicker" class="form-label">Select Month:</label>
                        <select id="monthPicker" class="form-select" name="to_selected_month" required>
                        <option value="" disabled selected>Select Month</option>
                        <?php
                            for ($i = 1; $i <= 12; $i++) {
                                $month = date('F', mktime(0, 0, 0, $i, 1));
                                $selected = isset($_POST['to_selected_year']) && $_POST['to_selected_year'] == $year ? 'selected' : '';
                                echo "<option value='$i'>$month</option>";
                            }
                        ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="yearPicker" class="form-label">Select Year:</label>
                        <select id="yearPicker" class="form-select" name="to_selected_year" required>
                        <option value="" disabled selected>Select Year</option>
                        <?php
                            $currentYear = date('Y');
                            for ($year = $currentYear + 1; $year >= $currentYear - 10; $year--) {
                                $selected = isset($_POST['to_selected_month']) && $_POST['to_selected_month'] == $i ? 'selected' : '';
                                echo "<option value='$year'>$year</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" name="filterMovingAverage">Apply Filter</button>
                </div>
            </form>

                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Moving Average</h4>

                                <?php
                                    include("mysql_connect.php");

                                    $sqlquery = "SELECT * FROM moving_average_tbl";

                                    $results = isset($filteredMovingAverage) ? $filteredMovingAverage : mysqli_query($conn, $sqlquery);

                                    if (mysqli_num_rows($results) > 0) {
                                        $data = array();
                                        // Add a new array for moving average data
                                        $data[] = array('Month', 'Sales', 'Moving Average');

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
                <script>
                        // JavaScript code to create a line chart using Chart.js
                        var ctx = document.getElementById('myChart').getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: <?php echo json_encode($labels); ?>,
                                datasets: [{
                                    label: 'Data',
                                    data: <?php echo json_encode($data); ?>,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 2,
                                    fill: false,
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        type: 'category',
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Sales Average'
                                        }
                                    }
                                }
                            }
                        });
                    </script>

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