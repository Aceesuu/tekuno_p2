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
    $query = "SELECT * FROM tb_order WHERE order_id = '$order_id'";

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
                            <div class="input-group">
                                <input type="text" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                                <span class="mdi mdi-magnify search-icon"></span>
                                <button class="input-group-text btn-primary" type="submit">Search</button>
                            </div>
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
                                <h4 class="page-title">Order Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Items from Order #<?php echo $order_data['order_id']; ?></h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Item Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['order_id'])) {
                                                    $order_id = $_GET['order_id'];

                                                    // Fetch order details from the tb_order table
                                                    $query = "SELECT * FROM tb_order WHERE order_id = '$order_id'";
                                                    $order_result = mysqli_query($conn, $query);

                                                    if ($order_result && mysqli_num_rows($order_result) > 0) {
                                                        while ($order_data = mysqli_fetch_assoc($order_result)) {
                                                ?>
                                                            <tr>
                                                                <td><img src="uploaded_img/<?php echo $order_data['image']; ?>" height="100" alt="product" class="rounded me-2"></td>
                                                                <td><?php echo $order_data['name']; ?>
                                                                    <br>
                                                                    <?php if (!empty($order_data['variation'])) : ?>
                                                                        <small><b>Variation:</b> <?php echo $order_data['variation']; ?></small>
                                                                    <?php endif; ?>

                                                                </td>
                                                                <td><?php echo $order_data['qty']; ?></td>
                                                                <td>₱<?php echo $order_data['price']; ?></td>
                                                                <td>₱<?php echo (($order_data['qty'] * $order_data['price'])); ?></td>
                                                            </tr>
                                                <?php
                                                        }
                                                    } else {
                                                        // Handle the case where order data couldn't be retrieved
                                                        $error_message = "Error: Unable to retrieve order data.";
                                                    }
                                                } else {
                                                    // Handle the case where the order_id parameter is not provided in the URL
                                                    $error_message = "Error: Missing order_id parameter.";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Order Summary</h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['order_id'])) {
                                                    $order_id = $_GET['order_id'];

                                                    // Fetch the order items from the tb_order table
                                                    $query = "SELECT * FROM tb_order WHERE order_id = '$order_id'";
                                                    $order_result = mysqli_query($conn, $query);

                                                    if ($order_result && mysqli_num_rows($order_result) > 0) {
                                                        $grand_total = 0;

                                                        while ($order_data = mysqli_fetch_assoc($order_result)) {
                                                            $item_total = $order_data['qty'] * $order_data['price'];
                                                            $grand_total += $item_total;
                                                            $discount = $order_data['discount'];
                                                        }

                                                        // Display the Grand Total
                                                ?>
                                                        <tr>
                                                            <td>Subtotal :</td>
                                                            <td>₱<?php echo $grand_total; ?></td>
                                                        </tr>
                                                        <?php

                                                        // Display the Shipping Charge
                                                        $shipping_charge = 40;
                                                        ?>
                                                        <tr>
                                                            <td>Shipping Charge :</td>
                                                            <td>₱<?php echo $shipping_charge; ?></td>
                                                        </tr>
                                                        <?php

                                                        ?>
                                                        <tr>
                                                            <td>Discount :</td>
                                                            <td>₱<?php echo $discount; ?></td>
                                                        </tr>
                                                        <?php

                                                        // Calculate and display the Total
                                                        $total = ($grand_total + $shipping_charge) - $discount;
                                                        ?>
                                                        <tr>
                                                            <td>Total :</td>
                                                            <td>₱<?php echo $total; ?></td>
                                                        </tr>
                                                <?php
                                                    } else {
                                                        // Handle the case where order data couldn't be retrieved
                                                        $error_message = "Error: Unable to retrieve order data.";
                                                    }
                                                } else {
                                                    // Handle the case where the order_id parameter is not provided in the URL
                                                    $error_message = "Error: Missing order_id parameter.";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- end table-responsive -->
                                </div>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Shipping Information</h4>
                                    <?php
                                    if (isset($_GET['order_id'])) {
                                        $order_id = $_GET['order_id'];

                                        // Fetch the order information including the user_id
                                        $query = "SELECT * FROM tb_order WHERE order_id = '$order_id'";
                                        $order_result = mysqli_query($conn, $query);

                                        if ($order_result && mysqli_num_rows($order_result) > 0) {
                                            $order_data = mysqli_fetch_assoc($order_result);

                                            // Retrieve the user_id from the order data
                                            $user_id = $order_data['user_id'];

                                            // Fetch the user's address from the users table
                                            $query_user = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
                                            $user_result = mysqli_query($conn, $query_user);

                                            if ($user_result && mysqli_num_rows($user_result) > 0) {
                                                $user_data = mysqli_fetch_assoc($user_result);
                                    ?>
                                                <h5><?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?></h5>
                                                <address class="mb-0 font-14 address-lg">
                                                    <?php echo $user_data['houseNo'] . ' ' . $user_data['street']; ?><br>
                                                    <?php echo $user_data['village'] . ' ' . $user_data['barangay']; ?><br>
                                                    <?php echo $user_data['postal'] ?>
                                                    <br>City of Pasig<br>
                                                    <abbr title="Contact">Contact:</abbr> <?php echo $user_data['contact']; ?><br>
                                                    <abbr title="Email">Email:</abbr> <?php echo $user_data['email']; ?>
                                                </address>
                                    <?php
                                            }
                                        } else {
                                            // Handle the case where order data couldn't be retrieved
                                            $error_message = "Error: Unable to retrieve order data.";
                                        }
                                    } else {
                                        // Handle the case where the order_id parameter is not provided in the URL
                                        $error_message = "Error: Missing order_id parameter.";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Order Status</h4>
                                    <?php
                                    $orderStatus = $order_data['order_status'];
                                    $badgeClass = '';

                                    // Define classes for each order status
                                    $statusClasses = [
                                        'Pending' => 'badge-info-lighten',
                                        'To Ship' => 'badge-success-lighten',
                                        'To Receive' => 'badge-warning-lighten',
                                        'Declined' => 'badge-danger-lighten',
                                    ];

                                    // Check if the order status exists in the array
                                    if (array_key_exists($orderStatus, $statusClasses)) {
                                        $badgeClass = $statusClasses[$orderStatus];
                                    }
                                    ?>
                                    <h2 class="<?php echo $badgeClass; ?>"><?php echo $orderStatus; ?></h2>
                                </div>
                            </div>
                        </div> <!-- end col -->


                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mb-3">Proof of Payment</h4>
                                    <img src="proof/<?php echo $order_data['proof_image']; ?>" height="300" alt="product" class="rounded me-2">
                                    <div class="text-center">

                                    </div>
                                </div>
                            </div>
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