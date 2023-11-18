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
    <title>Order</title>
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

    <link rel="stylesheet" href="css/order1.css">
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
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                        <li class="breadcrumb-item">Order</a></li>
                                        <li class="breadcrumb-item active">Order Details</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Order Details</h4>
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
                                                <div class="col-auto">
                                                    <div class="d-flex align-items-center">
                                                        <label for="status-select" class="me-2">Status</label>
                                                        <select class="form-select" id="status-select">
                                                            <option value="0">All</option>
                                                            <option value="1">Pending</option>
                                                            <option value="2">To Ship</option>
                                                            <option value="3">To Receive</option>
                                                            <option value="4">Decline</option>
                                                            <option value="5">Complete</option>
                                                            <option value="6">Cancelled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    

                                    <div class="table-responsive">
                                        <table id="example" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th class="all">Order ID</th>
                                                    <th>Grand Total</th>
                                                    <th>Order Status</th>
                                                    <th>Customer Name</th>
                                                    <th>Proof of Payment</th>
                                                    <th style="width: 85px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $select_products = mysqli_query($conn, "SELECT o.*, u.firstName, u.lastName FROM `tb_order` AS o INNER JOIN `tb_user` AS u ON o.user_id = u.user_id");
                                                $statusBadgeClasses = [
                                                    'Pending' => 'badge-info-lighten',
                                                    'To Ship' => 'badge-primary-lighten',
                                                    'To Receive' => 'badge-warning-lighten',
                                                    'Declined' => 'badge-danger-lighten',
                                                    'Complete' => 'badge-success-lighten',
                                                    'Cancelled' => 'badge-danger-lighten',
                                                ];

                                                $allOrders = [];

                                                if (mysqli_num_rows($select_products) > 0) {
                                                    while ($row = mysqli_fetch_assoc($select_products)) {
                                                        $orderId = $row['order_id'];
                                                        // Create a new entry for each order, including single-item orders
                                                        $orderData = [
                                                            'order_id' => $orderId,
                                                            'total' => $row['subtotal'],
                                                            'shipping' => 40, // Set the shipping cost for each order
                                                            'order_status' => $row['order_status'],
                                                            'discount' => $row['discount'],
                                                            'customerName' => $row['firstName'] . ' ' . $row['lastName'],
                                                            'proof_image' => $row['proof_image'],
                                                        ];

                                                        if (!isset($allOrders[$orderId])) {
                                                            $allOrders[$orderId] = $orderData;
                                                        } else {
                                                            // If the order already exists in the array, update the total amount
                                                            $allOrders[$orderId]['total'] += $orderData['total'];
                                                        }
                                                    }
                                                }

                                                foreach ($allOrders as $order) {
                                                ?>
                                                    <tr>
                                                        <td><u><a href="order_info.php?order_id=<?php echo $order['order_id']; ?>" class="text-body fw-bold">Order #<?php echo $order['order_id']; ?></a></u></td>
                                                        <td>
                                                            <?php
                                                            $total = $order['total'];
                                                            $discount = $order['discount'];
                                                            if (is_numeric($total) && is_numeric($discount)) {
                                                                $finalTotal = $total - $discount;
                                                                echo '₱' . $finalTotal;
                                                            } else {
                                                                echo $order['total'];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <h5><span class="badge <?php echo isset($statusBadgeClasses[$order['order_status']]) ? $statusBadgeClasses[$order['order_status']] : 'badge-info-lighten'; ?>">
                                                                    <?php echo $order['order_status']; ?>
                                                                </span></h5>
                                                        </td>
                                                        <td><?php echo $order['customerName']; ?></td>
                                                        <td><img src="proof/<?php echo $order['proof_image']; ?>" height="100" alt="proof" class="thumbnail" data-full-image="proof/<?php echo $order['proof_image']; ?>"></td>
                                                        <div id="fullImageContainer" class="hidden">
                                                            <img id="fullImage" src="" alt="">
                                                        </div>
                                                        <td class="table-action">
                                                            <button class="btn btn-primary" onclick="ToShip(<?php echo $order['order_id']; ?>)">To Ship</button>
                                                            <button class="btn btn-warning" onclick="ToReceive(<?php echo $order['order_id']; ?>)">To Receive</button>
                                                            <button class="btn btn-danger" onclick="declineOrder(<?php echo $order['order_id']; ?>)">Decline</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                </tr>
                                            </tbody>
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
    <script src="script.js"></script>


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
    <script>
        $(document).ready(function() {
            // Handle the change event of the select element
            $('#status-select').change(function() {
                var selectedStatus = $(this).val(); // Get the selected status value

                // Loop through each row in the table with the new ID "example"
                $('#example tbody tr').each(function() {
                    var row = $(this);

                    // Get the status in the current row
                    var rowStatus = row.find('td:eq(2) span').text().trim();

                    // Show or hide the row based on the selected status
                    if (selectedStatus === '0' || selectedStatus === '') {
                        // Show all rows if "All" or no status is selected
                        row.show();
                    } else if (selectedStatus === '1' && rowStatus === 'Pending') {
                        row.show();
                    } else if (selectedStatus === '2' && rowStatus === 'To Ship') {
                        row.show();
                    } else if (selectedStatus === '3' && rowStatus === 'To Receive') {
                        row.show();
                    } else if (selectedStatus === '4' && rowStatus === 'Declined') {
                        row.show();
                    } else if (selectedStatus === '5' && rowStatus === 'Complete') {
                        row.show();
                    } else if (selectedStatus === '6' && rowStatus === 'Cancelled') {
                        row.show();
                    } else {
                        // Hide the row if it doesn't match the selected status
                        row.hide();
                    }
                });
            });
        });
    </script>




</body>

</html>