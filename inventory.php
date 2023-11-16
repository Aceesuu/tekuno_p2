<?php
session_start();
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
<html>

<head>
    <meta charset="utf-8">
    <title>Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logoo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="script.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- DataTables Buttons JavaScript -->
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel="stylesheet" href="css/table.css">

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
                                        <li class="breadcrumb-item">Products</a></li>
                                        <li class="breadcrumb-item active">Inventory</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Inventory</h4>
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
                                            <!-- Content on the left side (if any) -->
                                        </div>
                                        <div class="col-xl-4 text-end"> <!-- Use text-end to right-align the button -->
                                            <div class="mt-2">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Stocks</button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table dt-responsive nowrap w-100" style="width:100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="all">Product ID</th>
                                                    <th>Product Name</th>
                                                    <th>Starting Quantity</th>
                                                    <th>New Quantity</th>
                                                    <th>Total Quantity</th>
                                                     <th>Stocks</th>
                                                    <th>Date Added</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $select_products = mysqli_query($conn, "SELECT * FROM `tb_product`");
                                                if (mysqli_num_rows($select_products) > 0) {
                                                    $total_quantity = 0;
                                                    while ($row = mysqli_fetch_assoc($select_products)) {
                                                        $stock_status = ($row['qty'] <= 0) ? 'Out of Stock' : 'Instock';
                                                        $badge_class = ($stock_status == 'Instock') ? 'badge-success-lighten' : 'badge-danger-lighten';
                                                ?>
                                                        <tr>

                                                            <td><?php echo $row['product_id']; ?></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['qty']; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row['new_qty'] > 0) {
                                                                    echo $row['new_qty'];
                                                                } else {
                                                                    echo "No New <br> Quantity available";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $total_qty = $row['qty'] + $row['new_qty'];
                                                                echo $total_qty;
                                                                $total_quantity += $total_qty;
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <h4><span class="badge <?php echo $badge_class; ?>"><?php echo $stock_status; ?></span></h4>
                                                            </td>
                                                            <td><?php echo $row['purchase_date']; ?></td>
                                                    <?php
                                                    }
                                                }
                                                    ?>

                                            </tbody>
                                        </table>

                                        <!-- Add Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Add Stock</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="crud_inventory.php" method="post" class="add-product-form" enctype="multipart/form-data">

                                                            <div class="mb-3">
                                                                <input type="hidden" name="update_p_id" value="<?php echo $row['product_id']; ?>">
                                                                <label for="simpleinput" class="form-label">Product Name</label>
                                                                <select name="p_name" class="form-control" required>
                                                                    <option value="" disabled selected>Select product</option>
                                                                    <?php
                                                                    $sql = "SELECT name FROM tb_product";
                                                                    $result = mysqli_query($conn, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="simpleinput" class="form-label">Quantity</label>
                                                                    <input type="number" min="1" value="1" name="p_qty" class="form-control" required style="width: 90px;">
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="add_product" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                        <!-- end row -->

                    </div> <!-- container -->

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



                <!-- bundle -->
                <script src="assets/js/vendor.min.js"></script>
                <script src="assets/js/app.min.js"></script>

                <script>
                    $(document).ready(function() {
                        var table = $('#example').DataTable({
                            dom: 'Bfrtip', // Specify the layout of the DataTable with buttons
                            buttons: [{
                                    extend: 'copy', // Copy to clipboard
                                    className: 'custom-button', // Add a custom CSS class
                                },
                                {
                                    extend: 'excel', // Export to Excel
                                    className: 'custom-button', // Add a custom CSS class
                                },
                                {
                                    extend: 'pdf', // Export to PDF
                                    className: 'custom-button', // Add a custom CSS class
                                },
                                {
                                    extend: 'print', // Print the table
                                    className: 'custom-button', // Add a custom CSS class
                                },
                                {
                                    extend: 'colvis', // Add the ColVis button
                                    className: 'custom-button', // Add a custom CSS class
                                }
                            ]
                        });
                    });
                </script>

</body>

</html>