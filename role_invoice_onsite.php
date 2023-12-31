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

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the tb_order table
    $query = "SELECT * FROM order_onsite WHERE order_id = '$order_id'";

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
<html>

<head>
    <meta charset="utf-8">
    <title>Order Onsite</title>
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
            <a href="dashboard-order.php" class="logo text-center logo-light">
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
                        <a href="dashboard-order.php" class="side-nav-link">
                            <i class="dripicons-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a  href="#sidebarEcommerceOrder" aria-expanded="false" aria-controls="sidebarEcommerceOrder" class="side-nav-link">
                            <i class=" uil-shopping-cart-alt"></i>
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
                                        <li class="breadcrumb-item active"></li>
                                    </ol>
                                </div>
                                <h4 class="page-title"></h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->



                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">

                                    <!-- Invoice Logo-->
                                    <div class="clearfix">
                                        <div class="float-start mb-3">
                                            <img src="assets/images/logoinv.png" alt="" height="80">
                                        </div>
                                        <div class="float-end">
                                            <h4 class="m-0 d-print-none">Onsite Invoice</h4>
                                        </div>
                                    </div>

                                    <!-- Invoice Detail-->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="float-end mt-3">
                                                <p><b>Hello, Customer</b></p>
                                                <p class="text-muted font-13">Payment has been successfully processed, and here is the invoice for your order. If you have any further questions, please don't hesitate to contact our number.
                                                </p>
                                            </div>

                                        </div><!-- end col -->
                                        <div class="col-sm-4 offset-sm-2">
                                            <div class="mt-3 float-sm-end">
                                                <p class="font-13"><strong>Order Date: </strong> &nbsp;&nbsp;&nbsp; <?php echo $order_data['order_date']; ?></p>
                                                <p class="font-13"><strong>Order ID: </strong> &nbsp;&nbsp;&nbsp; #<?php echo $order_data['order_id']; ?></p>
                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row mt-4">
                                        <div class="col-sm-4">
                                            <h6>Company Address</h6>
                                            <address>
                                                Kat & Ren Construction Supply<br>
                                                84 Urbano Velasco Ave. Pinagbuhatan<br>
                                                Pasig City<br>
                                                02-8907-26-05
                                            </address>
                                        </div> <!-- end col-->
                                    </div>
                                    <!-- end row -->

                                    <?php
                                    if (isset($_GET['order_id'])) {
                                        $order_id = $_GET['order_id'];

                                        // Query the database to get orders with the specified order_id
                                        $select_orders = mysqli_query($conn, "SELECT * FROM `order_onsite` WHERE order_id = '$order_id'");

                                        $grand_total = 0;
                                        $total_discount = 0; // Initialize total discount
                                        $discountApplied = false;
                                        $total_subtotal = 0; // Initialize total_subtotal

                                    ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table mt-4">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Price</th>
                                                                <th>Quantity</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $grand_total = 0;
                                                            $total = 0;
                                                            $sub_total = 0;
                                                            $discounted_price = 0;
                                                            $discount_rate = 0.03;

                                                            while ($fetch_cart = mysqli_fetch_assoc($select_orders)) {
                                                                $quantity = $fetch_cart['qty'];
                                                                $price = $fetch_cart['price'];
                                                                $subtotal = $fetch_cart['subtotal'];


                                                                // Calculate the discounted price without shipping fee
                                                                $subtotal = $fetch_cart['subtotal'];
                                                                $discounted_price = ($subtotal >= 5000) ? $subtotal * (1 - $discount_rate) : $subtotal;

                                                                // Calculate tax on the discounted subtotal
                                                                $tax_rate = 0.12;
                                                                $tax = $discounted_price * $tax_rate;

                                                                // Calculate the grand total without shipping fee
                                                                $grand_total = $discounted_price + $tax;

                                                                // Calculate the discount
                                                                $discount = ($subtotal >= 5000) ? $subtotal - $discounted_price : 0;
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <p class="m-0 d-inline-block align-middle">
                                                                            <a href="#" class="text-body fw-semibold"><?php echo $fetch_cart['name']; ?></a>
                                                                        </p>
                                                                    </td>
                                                                    <td><?php echo number_format($fetch_cart['price']); ?></td>
                                                                    <td><?php echo $fetch_cart['qty']; ?></td>
                                                                    <td>₱<?php echo $fetch_cart['subtotal']; ?></td>
                                                                    <!-- Display item-level discount -->
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div> <!-- end table-responsive-->
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="clearfix pt-3">
                                                    <h6 class="text-muted">Notes:</h6>
                                                    <small>
                                                        Check the purchased product, and if you have any concerns, please feel free to contact us.
                                                    </small>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-sm-6">
                                                <div class="float-end mt-3 mt-sm-0">
                                                    <p><b>Subtotal:</b> <span class="float-end">₱<?= number_format($subtotal, 2) ?></span></p>
                                                    <?php if ($sub_total >= 5000) { ?>
                                                        <p><b>Discounted Rate: </b> &nbsp; 3%</p>
                                                        <p><b>Discounted Price:</b> &nbsp; <span class="float-end">₱<?= number_format($discounted_price, 2) ?></span></p>
                                                    <?php } ?>
                                                    <p><b>Sales Tax:</b> <span class="float-end">₱<?= number_format($tax, 2) ?></span></p>
                                                    <p><b>Grand Total:</b>
                                                    <h3>₱<?= number_format($grand_total, 2) ?></h3>
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row-->
                                        <div class="d-print-none mt-4">
                                            <div class="text-end">
                                                <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                        // Handle the case when no order_id is provided in the URL
                                        echo "No order_id specified in the URL.";
                                    }
                                    ?>

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
                            ],
                            ordering: false // Disable sorting
                        });
                    });
                </script>

                <script>
                    function updateTotalPrice() {
                        var price = parseFloat($('#price').val()) || 0;
                        var qty = parseInt($('#p_qty').val()) || 0;

                        var total_price = price * qty;
                        $('#total_price').val(total_price.toFixed(2));
                    }

                    $(document).ready(function() {
                        $('#p_name').on('change', function() {
                            var selectedOption = $(this).find('option:selected');
                            if (selectedOption) {
                                var price = selectedOption.data('price');
                                var qty = selectedOption.data('qty');
                                var product_id = selectedOption.val(); // Get the product ID
                                $('#price').val(price);
                                $('#avail_quan').val(qty);
                                $('#product_id').val(product_id);
                                updateTotalPrice();
                            } else {
                                $('#price').val('');
                                $('#avail_quan').val('');
                                $('#total_price').val('');
                                $('#product_id').val('');
                            }
                        });

                        $('#p_qty').on('input', function() {
                            updateTotalPrice();
                        });
                    });
                </script>

</body>

</html>