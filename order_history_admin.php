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

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the tb_order table
    $query = "SELECT * FROM tb_order WHERE user_id = '$order_id'";

    $order_result = mysqli_query($conn, $query);

    if ($order_result && mysqli_num_rows($order_result) > 0) {
        $order_data = mysqli_fetch_assoc($order_result);
        // Now you can use $order_data to access order information.
    } else {
        // Handle the case where order data couldn't be retrieved
        $error_message = "Error: Unable to retrieve order data.";
    }
} else {
    // Handle the case where the order_id parameter is not provided in the URL
    $error_message = "Error: Missing order_id parameter.";
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
                                    <i class=" uil-shopping-cart-alt"></i>
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
                                    <i class=" uil-shopping-cart-alt"></i>
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
                    <div class="app-search dropdown d-none d-lg-block">
                        <form>
                          
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
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                        <li class="breadcrumb-item active">Order</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Order History</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-xl-8">
                                            <form class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between">
                                            </form>
                                        </div>
                                      
                                    </div>

                                    <div class="table-responsive">
                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="all">Customer ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Total No. of Orders</th>
                                                    <th>Order Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $select_users_with_orders = mysqli_query($conn, "
                                                    SELECT u.user_id, CONCAT(u.firstName, ' ', u.lastName) AS customerName, COUNT(DISTINCT o.order_id) AS orderCount
                                                    FROM `tb_user` u
                                                    LEFT JOIN `tb_order` o ON u.user_id = o.user_id
                                                    WHERE u.status = 1
                                                    GROUP BY u.user_id
                                                    HAVING orderCount > 0
                                                ");

                                                while ($row = mysqli_fetch_assoc($select_users_with_orders)) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['user_id']; ?></td>
                                                        <td><?php echo $row['customerName']; ?></td>
                                                        <td><?php echo $row['orderCount']; ?></td>
                                                        <td><a href="order_details_admin.php?user_id=<?php echo $row['user_id']; ?>" class="action-icon"> <i class="mdi mdi-eye"></i> View</a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </table>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
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