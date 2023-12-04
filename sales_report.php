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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logoo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">
    <link href="assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <link rel="stylesheet" href="text/design.css">

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">

    <style>
        #image-preview {
            max-width: 100%;
            height: 200px;
            margin-top: 10px;
        }

        #preview-image {
            width: 200px;
            /* Set the width to 200 pixels */
        }
    </style>
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
                                <i class=" uil-shopping-cart-alt"></i>
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

                    <div class="clearfix"></div>
                </ul>
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


                    <span class="noti-icon-badge"></span>
                    </a>
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
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Sales Reports</a></li>
                                    <li class="breadcrumb-item active">Reports</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Sales Reports</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <center>
                                    <form id="searchForm">
                                        <label for="startDate"><b>Start Date:</b></label>
                                        <input type="date" id="startDate" name="startDate" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <label for="endDate"><b>End Date:</b></label>
                                        <input type="date" id="endDate" name="endDate" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                        <button type="button" class="btn btn-primary" onclick="searchOrders()">Search</button>
                                        <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i>PDF</a>
                                    </form>
                                </center>
                                <br>

                                <div id="resultContainer"></div>


                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                    </div> <!-- container -->
                </div>


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

        <script>
            function searchOrders() {
                var startDate = document.getElementById("startDate").value;
                var endDate = document.getElementById("endDate").value;

                // Assuming you're using AJAX to send the data to the server
                // You can replace the following lines with your preferred AJAX method
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("resultContainer").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "search1.php?startDate=" + startDate + "&endDate=" + endDate, true);
                xhttp.send();
            }
        </script>

        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>

        <!-- third party js -->
        <script src="assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="assets/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="assets/js/vendor/dataTables.responsive.min.js"></script>
        <script src="assets/js/vendor/responsive.bootstrap5.min.js"></script>
        <script src="assets/js/vendor/dataTables.checkboxes.min.js"></script>

        <!-- Datatable Init js -->
        <script src="assets/js/pages/demo.datatable-init.js"></script>

        <!-- third party js ends -->
        <!-- end demo js-->


        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-o6bLTM2BjR41l/6t1Sss/OtX4Yp1p2qE6neGJ0wMmR8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha256-YozT52Tvl6FsThQz3DlF6b6t8zVf3DzA/0H3A6EiPPE=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha384-Kay7B3Qj2TqpBMp7rN7R+JGzxp7F2bNQfDHxng5tQ8o66fwW0ueRdKp5l3kI33dM" crossorigin="anonymous"></script>

        <script>
            // JavaScript/jQuery code to set the product_id value and show the confirmation modal
            $(document).ready(function() {
                $(".delete-btn").click(function() {
                    var product_id = $(this).data('product-id');
                    $("#product_id").val(product_id);
                    $('#deleteConfirmationModal').modal('show');
                });
            });
        </script>

        <script>
            const fileInput = document.getElementById('example-fileinput');
            const imagePreview = document.getElementById('preview-image');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener('load', function() {
                        imagePreview.src = reader.result;
                    });

                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = '';
                }
            });
        </script>

</body>

</html>