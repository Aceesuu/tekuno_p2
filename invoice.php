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

$select_products = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `user_id` = $user_id");
$prod = mysqli_fetch_assoc($select_products);

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

<style>
    @media print {
    .no-page-break {
        page-break-inside: avoid;
    }
}
</style>

<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom topnav-navbar" style="background-color: #212A37;">
                    <div class="container-fluid">

                        <!-- LOGO -->
                        <a href="" class="topnav-logo">
                            <span class="topnav-logo-lg">
                                <img src="assets/images/logoo.png" alt="" height="67">
                            </span>
                            <span class="topnav-logo-sm">
                                <img src="assets/images/logoo.png" alt="" height="67">
                            </span>
                        </a>

                        <ul class="list-unstyled topbar-menu float-end mb-0">
                            <li class="dropdown notification-list">
                                <!-- Add to Home link -->
                                <a class="nav-link" href="dashboard-customer.php" style="display: flex; align-items: center;">
                                    <i class="dripicons-home" style="font-size: 25px; margin-top: 15px;"></i>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to Cart link -->
                                <a class="nav-link" href="addcart.php" style="display: flex; align-items: center;">
                                    <i class='uil uil-shopping-cart-alt' style="font-size: 25px; margin-top: 17px;"></i>
                                    <span id="cart-count" class="red-number">0</span>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to proof link -->
                                <a class="nav-link" href="proof_customer.php" style="display: flex; align-items: center;">
                                    <i class="dripicons-wallet" style="font-size: 25px; margin-top: 15px;"></i>
                                </a>
                            </li>

                            <li class="dropdown notification-list">
                                <!-- Add to order link -->
                                <a class="nav-link" href="order_customer.php" style="display: flex; align-items: center;">
                                    <i class="mdi mdi-inbox-multiple" style="font-size: 25px; margin-top: 15px;"></i>
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
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0 custom-bg-color" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <span class="account-user-avatar">
                                        <?php
                                        $user_image = $user_data['image'];
                                        if (!empty($user_image)) {
                                            // Display the user's image if available
                                            echo '<img src="user_profile_img/' . $user_image . '" alt="user" class="rounded-circle">';
                                        } else {
                                            // Display a default avatar image when no user image is available
                                            echo '<img src="assets/images/profile.jpg" alt="Default Avatar" class="rounded-circle">';
                                        }
                                        ?>
                                    </span>
                                    <span class="account-user-name"><?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                                    <!-- item-->
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
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
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item active">Invoice</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Invoice</h4>
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
                                                <img src="assets/images/logoo.png" alt="" height="67">
                                            </div>
                                            <div class="float-end">
                                                <h4 class="m-0 d-print-none">Invoice</h4>
                                            </div>
                                        </div>

                                        <!-- Invoice Detail-->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="float-end mt-3">
                                                    <p><b>Hello, <?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?></b></p>
                                                    <p class="text-muted font-13">Please make payment at your earliest convenience, and do not hesitate to contact our number for further questions.</p>
                                                </div>
            
                                            </div><!-- end col -->
                                            <div class="col-sm-4 offset-sm-2">
                                                <div class="mt-3 float-sm-end">
                                                    <p class="font-13"><strong>Order Date: </strong> &nbsp;&nbsp;&nbsp; <?php echo $prod['order_date']; ?></p>
                                                    <p class="font-13"><strong>Order Status: </strong> <span class="badge bg-success float-end"><?php echo $prod['order_status']; ?></span></p>
                                                </div>
                                            </div><!-- end col -->
                                        </div>
                                        <!-- end row -->
            
                                        <div class="row mt-4">
                                            <div class="col-sm-4">
                                                <h6>Billing Address</h6>
                                                <address>
                                                    Kat & Ren Construction Supply<br>
                                                    84 Urbano Velasco Ave. Pinagbuhatan<br>
                                                    Pasig City<br>
                                                    02-8907-26-05
                                                </address>
                                            </div> <!-- end col-->
            
                                            <div class="col-sm-4">
                                                <h6>Shipping Address</h6>
                                                <address>
                                                    <?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?><br>
                                                    <?php echo $user_data['street'] . ' ' . $user_data['barangay']; ?><br>
                                                    Pasig City<br>
                                                    <?php echo $user_data['contact']; ?>
                                                </address>
                                            </div> <!-- end col-->
            
                                            <div class="col-sm-4">
                                                <div class="text-sm-end">
                                                    <img src="proof/<?php echo $prod['proof_image']; ?>" height="180" width="150" alt="proof-img" title="contact-img" class="rounded me-2">
                                                </div>
                                            </div> <!-- end col-->
                                        </div>    
                                        <!-- end row -->        
    
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table class="table mt-4">
                                                        <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Cost</th>
                                                            <th class="text-end">Total</th>
                                                        </tr></thead>
                                                        <?php
                                                        $select_cart = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE user_id = '$user_id'");
                                                        $grand_total = 0;
                                                        $total_discount = 0;
                                                        $discountApplied = false;
                                                        $shipping_fee = 40; // Shipping fee value

                                                        if (mysqli_num_rows($select_cart) > 0) {
                                                            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                                                $quantity = $fetch_cart['qty'];
                                                                $price = $fetch_cart['price'];

                                                                // Calculate the discount for this item
                                                                $discounted_price = 0; // Default price without discount
                                                                if ($quantity >= 5) {
                                                                    $discounted_price = $price * 0.1; // 10% discount
                                                                    $discountApplied = true; // Set the flag to true
                                                                }

                                                                // Calculate the subtotal for this item
                                                                $sub_total = $price * $quantity;

                                                                // Add the subtotal to the grand total
                                                                $grand_total += $sub_total;

                                                                // Add the discount for this item to the total discount
                                                                $total_discount += $discounted_price;
                                                        ?>
                                                        <tbody>
                                                        <tr>
                                                            <td>
                                                                <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="50" alt="contact-img" title="contact-img" class="rounded me-2">
                                                                <p class="m-0 d-inline-block align-middle">
                                                                <a href="#" class="text-body fw-semibold"><?php echo $fetch_cart['name']; ?></a>
                                                                </p>
                                                            </td>
                                                            <td><?php echo $fetch_cart['qty']; ?></td>
                                                            <td><?php echo number_format($fetch_cart['price']); ?></td>
                                                            <td class="text-end">₱<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['qty']); ?></td>
                                                        </tr>

                                                        <?php
                                                          }
                                                        }

                                                        // Calculate the total before discount and shipping fee
                                                        $total_before_discount_and_shipping = $grand_total;
                                                         // Subtract the total discount from the grand total
                                                          $grand_total -= $total_discount;

                                                         // Add the shipping fee to the grand total
                                                         $grand_total += $shipping_fee;

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
                                                        All accounts are to be paid within 7 days from receipt of
                                                        invoice. To be paid by Gcash
                                                        online. If account is not paid within 7 days the the order
                                                        will be declined
                                                    </small>
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-sm-6">
                                                <div class="float-end mt-3 mt-sm-0">
                                                    <p><b>Sub-total:</b> <span class="float-end">₱<?= number_format($total_before_discount_and_shipping, 2) ?></span></p>
                                                    <p><b>Shipping Fee:</b> <span class="float-end">₱<?= number_format($shipping_fee, 2) ?></span></p>
                                                    <p><b>Discount:</b> <span class="float-end"><?php
                                                                            if ($discountApplied) {
                                                                                echo '₱-' . number_format($total_discount, 2) . '</td>';
                                                                            } else {
                                                                                echo '₱0.00</td>';
                                                                            }
                                                                        ?></span></p>
                                                    <h3>₱<?php echo number_format($grand_total); ?></h3>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row-->
    
                                        <div class="d-print-none mt-4">
                                            <div class="text-end">
                                                <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> Print</a>
                                            </div>
                                        </div>   
                                        <!-- end buttons -->

                                    </div> <!-- end card-body-->
                                </div> <!-- end card -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container -->

            </div> <!-- content endtag -->
        </div> <!-- content page endtag -->
</div> <!-- wrapper endtag -->




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