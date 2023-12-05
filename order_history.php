<?php
session_start(); // Start the session
include "mysql_connect.php";

if (!isset($_SESSION['user_id'])) {
    // Redirect to index.php or login page if user is not logged in
    header("Location: index.php"); // Update with your login page URL
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $query);

if ($user_result && mysqli_num_rows($user_result) > 0) {
    $user_data = mysqli_fetch_assoc($user_result);
    // Now you can use $user_data to access user information
} else {
    // Handle the case where user data couldn't be retrieved
    $error_message = "Error: Unable to retrieve user data.";
}


?>


<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Kat & Ren Construction Supply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/check.css">

</head>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom topnav-navbar" style="background-color: #212A37; height: 85px;">
                    <div class="container-fluid">

                        <!-- LOGO -->
                        <a href="" class="topnav-logo">
                            <span class="topnav-logo-lg">
                                <img src="assets/images/logo.png" alt="" height="69">
                            </span>
                            <span class="topnav-logo-sm">
                                <img src="assets/images/logo.png" alt="" height="69">
                            </span>
                        </a>

                        <ul class="list-unstyled topbar-menu float-end mb-0">

                            <li class="dropdown notification-list">
                                <!-- Add to Home link -->
                                <a class="nav-link" href="dashboard-customer.php" style="display: flex; align-items: center;">
                                    <i class="mdi mdi-home-outline" style="font-size: 27px; margin-top: 15px;"></i>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to Cart link -->
                                <a class="nav-link" href="addcart.php" style="display: flex; align-items: center;">
                                    <i class='uil uil-shopping-cart-alt' style="font-size: 25px; margin-top: 15px;"></i>
                                    <span id="cart-count" class="red-number">0</span>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to proof link -->
                                <a class="nav-link" href="order_customer.php" style="display: flex; align-items: center;">
                                    <i class="mdi mdi-inbox-multiple" style="font-size: 25px; margin-top: 15px;"></i>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to proof link -->
                                <a class="nav-link" href="proof_customer.php" style="display: flex; align-items: center;">
                                    <i class="dripicons-wallet" style="font-size: 24px; margin-top: 15px;"></i>
                                </a>
                            </li>

                          <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="dripicons-bell noti-icon"></i>
                                    <span class="noti-icon-badge"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg" aria-labelledby="topbar-notifydrop">

                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                            <span class="float-end">

                                            </span>Notification

                                        </h5>
                                    </div>


                                    <?php
                                    $sql = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `user_id` = $user_id ORDER BY `order_id` DESC, `order_date` ASC LIMIT 5");

                                    if (mysqli_num_rows($sql) > 0) {
                                        $orders = array();

                                        while ($row = mysqli_fetch_assoc($sql)) {
                                            $order_id = $row['order_id'];

                                            // Use order_id as the key and update the status if a newer one is found
                                            if (!isset($orders[$order_id]) || $row['order_date'] > $orders[$order_id]['order_date']) {
                                                $orders[$order_id] = array(
                                                    'order_id' => $order_id,
                                                    'status' => $row['order_status'],
                                                    'order_date' => $row['order_date'],
                                                );
                                            }
                                        }

                                        foreach ($orders as $order) {
                                    ?>
                                            <div style="max-height: 230px;" data-simplebar="">

                                                <a href="order_customer.php" class="dropdown-item notify-item">
                                                    <div class="notify-icon bg-primary">
                                                        <i class="mdi mdi-comment-account-outline"></i>
                                                    </div>
                                                    <p class="notify-details">Your Order # <?php echo $order['order_id']; ?> has the <br>
                                                        status of <?php echo $order['status']; ?></p>
                                                    <small class="text-muted"><?php echo $order['order_date']; ?></small>
                                                    </p>
                                                </a>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<a href="#" class="dropdown-item notify-item">';
                                        echo '    <p class="notify-details">No orders</p>';
                                        echo '</a>';
                                    }
                                    ?>

                                    <!-- All-->
                                    <a href="viewall_notif.php" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View All
                                    </a>

                                </div>

                            </li>


                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 custom-bg-color" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="account-user-avatar">
                                        <?php
                                        $user_image = $user_data['image'];
                                        if (!empty($user_image)) {
                                            // Display the user's image if available
                                            echo '<img src="uploaded_img/' . $user_image . '" alt="user" class="rounded-circle">';
                                        } else {
                                            // Display a default avatar image when no user image is available
                                            echo '<img src="assets/images/profile.jpg" alt="Default Avatar" class="rounded-circle">';
                                        }
                                        ?>
                                    </span>
                                    <span class="account-user-name"><?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                                    <!-- item-->
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="user_profile.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span>My Account</span>
                                    </a>
   <a href="order_history.php" class="dropdown-item notify-item">
                                        <i class=" mdi mdi-briefcase-clock"></i>
                                        <span>Order History</span>
                                    </a>

                                    <!-- item-->
                                    <a href="logout.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>
                        <a class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>

                    </div>
                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="border p-3 mt-4 mt-lg-0 rounded">
                        <h3 class="header-title mb-3" style="text-align: center;">Order History</h3>
                        <div class="table-responsive">
                            <table class="table table-centered mb-0">
                                <tbody>
                                    <?php
                                    $select_products = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `user_id` = $user_id ORDER BY `order_id`");
                                    $prev_order_id = null; // Initialize the previous order ID variable
                                    $statusBadgeClasses = [
                                        'Pending' => 'badge-info-lighten',
                                        'To Ship' => 'badge-primary-lighten',
                                        'To Receive' => 'badge-warning-lighten',
                                        'Declined' => 'badge-danger-lighten',
                                        'Complete' => 'badge-success-lighten',
                                        'Accept' => 'badge-success-lighten',
                                        'Cancelled' => 'badge-danger-lighten',
                                        'Decline' => 'badge-danger-lighten',
                                    ];

                                    if (mysqli_num_rows($select_products) > 0) {
                                        while ($row = mysqli_fetch_assoc($select_products)) {
                                            $current_order_id = $row['order_id'];

                                            // Check if the current order ID is different from the previous one
                                            if ($current_order_id != $prev_order_id) {
                                                // Close the previous table if it's not the first iteration
                                                if ($prev_order_id !== null) {
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                                                }

                                                // Display the unique order ID
                    ?>
                    <h4 class="header-title mb-3"> Order# <?php echo $current_order_id; ?> </h4>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Order Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                            }

                            ?>
                            <tr>
                                <td>
                                    <img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt="contact-img" title="contact-img" class="rounded me-2">
                                    <p class="m-0 d-inline-block align-middle">
                                        <a href="#" class="text-body fw-semibold"><?php echo $row['name']; ?></a>
                                        <br>
                                        <small><?php echo $row['qty']; ?> x <?php echo number_format($row['price']); ?></small>
                                    </p>
                                </td>
                                <td><?php echo $row['qty']; ?></td>
                                <td>₱<?php echo $row['price']; ?></td>
                                <td>
                                    <h5><span class="badge <?php echo isset($statusBadgeClasses[$row['order_status']]) ? $statusBadgeClasses[$row['order_status']] : 'badge-info-lighten'; ?>">
                                            <?php echo $row['order_status']; ?>
                                        </span></h5>
                                </td>
                            </tr>
                        <?php

                                            // Update the previous order ID variable
                                            $prev_order_id = $current_order_id;
                                        }
                                    }

                                    // Close the last table if there are results
                                    if (mysqli_num_rows($select_products) > 0) {
                        ?>
                            </tbody>
                        </table>
                    </div>
                <?php
                                    }
                ?>


                <!-- end table-responsive -->

                    </div>
                </div> <!-- end col -->


                <!-- end table-responsive -->
            </div> <!-- end .border-->

        </div> <!-- end row-->

    </div> <!-- end col -->
    </div> <!-- end row-->
    </div>
    <!-- End Payment Information Content-->

    </div> <!-- end tab content-->

    </div> <!-- end card-body-->
    </div> <!-- end card-->
    </div> <!-- end col -->
    </div>
    <!-- end row-->

    </div> <!-- container -->

    </div> <!-- content -->


    <!-- content -->

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



    <!-- /End-bar -->

    <!-- bundle -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="assets/js/app.min.js"></script>



    <!-- demo app -->
    <script src="assets/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

    <script>
        const proofFileInput = document.getElementById('proofFile');
        const filePreviewContainer = document.getElementById('filePreview');

        proofFileInput.addEventListener('change', function() {
            while (filePreviewContainer.firstChild) {
                filePreviewContainer.removeChild(filePreviewContainer.firstChild);
            }

            const files = this.files;
            for (const file of files) {
                const fileType = file.type.split('/')[0]; // Get the type of the file (image or pdf)

                if (fileType === 'image') {
                    const imagePreview = document.createElement('img');
                    imagePreview.src = URL.createObjectURL(file);
                    imagePreview.style.maxWidth = '100%';
                    imagePreview.style.height = 'auto';
                    filePreviewContainer.appendChild(imagePreview);
                } else if (fileType === 'application' && file.type === 'application/pdf') {
                    const pdfPreview = document.createElement('iframe');
                    pdfPreview.src = URL.createObjectURL(file);
                    pdfPreview.style.width = '100%';
                    pdfPreview.style.height = '300px'; // Adjust the height as needed
                    filePreviewContainer.appendChild(pdfPreview);
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Your existing JavaScript code for handling other functionalities here.
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to update the cart count from the server
        function updateCartCount() {
            $.ajax({
                url: 'get_cart_count.php', // Replace with the actual URL of your PHP script
                method: 'GET',
                success: function(response) {
                    $('#cart-count').text(response);
                },
                error: function() {
                    // Handle the error if the request fails
                    console.error('Failed to fetch cart count');
                }
            });
        }

        // Call the updateCartCount function to initialize the cart count
        updateCartCount();
    </script>
</body>

</html>