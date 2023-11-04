<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id'])) {
    // Redirect to index.php or login page if user is not logged in
    header("Location: index.php"); // Update with your login page URL
    exit();
}
include("mysql_connect.php");
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

$sql = "SELECT * FROM tb_user WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row["firstName"];
    $lastName = $row["lastName"];
    $middleName = $row['middleName'];
    $gender = $row['gender'];
    $contact = $row['contact'];
    $bdate = $row['bdate'];
    $houseNo = $row['houseNo'];
    $street = $row['street'];
    $barangay = $row['barangay'];
    $village = $row['village'];
    $postal = $row['postal'];
} else {
    echo "No data found";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Account Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link rel="stylesheet" href="css/custom1.css">

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
                <div class="navbar-custom topnav-navbar" style="background-color: #323B47;">
                    <div class="container-fluid">

                        <!-- LOGO -->
                        <a href="" class="topnav-logo">
                            <span class="topnav-logo-lg">
                                <img src="assets/images/custo.png" alt="" height="70">
                            </span>
                            <span class="topnav-logo-sm">
                                <img src="assets/images/custo.png" alt="" height="70">
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
                                <!-- Add to proof link -->
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
                                            echo '<img src="user_profile_img/' . $user_image . '" alt="user" class="rounded-circle" style="height: auto;">';
                                        } else {
                                            // Display a default avatar image when no user image is available
                                            echo '<img src="assets/images/profile.jpg" alt="Default Avatar" class="rounded-circle" style="height: auto;">';
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
                    </div>
                </div>
                <!-- end Topbar -->


                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Account Settings</h4>
                            </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row gutters">
                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                <div class="card h-27">
                                    <div class="card-body">
                                        <div class="account-settings">
                                            <div class="user-profile">
                                                <div class="user-avatar">
                                                    <?php
                                                    $user_image = $user_data['image'];

                                                    if (!empty($user_image)) {
                                                        // Display the user's image if available
                                                        echo '<img src="user_profile_img/' . $user_image . '" alt="user">';
                                                    } else {
                                                        // Display a default avatar image when no user image is available
                                                        echo '<img src="assets/images/profile.jpg" alt="Default Avatar">';
                                                    }
                                                    ?>
                                                </div>
                                                <h5 class="user-name"><?php echo $user_data['firstName'] . ' ' . $user_data['lastName']; ?></h5>
                                                <form action="upload.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                                                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $row['user_id']; ?>">
                                                        <i class="mdi mdi-clipboard-edit"></i>
                                                    </button>
                                                    <!-- Edit MODAL -->
                                                    <div class="modal fade" id="edit_<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="ModalLabel">Edit Profile</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="POST" action="upload.php" enctype="multipart/form-data">
                                                                        <input type="hidden" name="update_p_id" value="<?php echo $row['user_id']; ?>">
                                                                        <div class="mb-3 row">
                                                                            <div class="col-sm-10">
                                                                                <?php
                                                                                $existing_image = $row['image'];
                                                                                if (!empty($existing_image)) {
                                                                                    echo '<img src="user_profile_img/' . $existing_image . '" alt="Existing Image">';
                                                                                } else {
                                                                                    // Display a default avatar image when no user image is available
                                                                                    echo '<img src="assets/images/profile.jpg" alt="Default Avatar" style="max-width: 100px;">';
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mb-3 row">
                                                                            <div class="col-sm-10">
                                                                                <input type="file" class="form-control" name="update_p_image">
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" name="update_user" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <form method="POST" action="upload.php">
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mb-2" style="color: #F7931E;">Personal Details</h6>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <input type="hidden" name="update_u_id" value="<?php echo $row['user_id']; ?>">
                                    <div class="form-group">
                                        <label for="lastname" class="form-label"><i class="fas fa-user"></i>Last Name</label>
                                        <input class="form-control" type="text" name="lastName" id="lastNameInput" placeholder="Enter your Last Name" value="<?php echo $lastName; ?>" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input class="form-control" type="text" name="firstName" id="firstNameInput" value="<?php echo $firstName; ?>" placeholder="Enter your First Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="middlename" class="form-label">Middle Name</label>
                                        <input class="form-control" type="text" name="middleName" id="middleNameInput" placeholder="Enter your Middle Name" value="<?php echo $middleName; ?>">
                                        <small class="form-text text-muted">If you do not have a middle name, you can leave this
                                            field blank.</small>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="" disabled>Select your gender</option>
                                        <option value="Female" <?php if ($gender === "Female") echo "selected"; ?>>Female</option>
                                        <option value="Male" <?php if ($gender === "Male") echo "selected"; ?>>Male</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="birthdate">Birthdate</label>
                                        <input type="date" class="form-control" name="bdate" id="bdate" required value="<?php echo $row["bdate"]; ?>">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="contact" class="form-label">Contact Number</label>
                                        <input class="form-control" type="text" name="contact" id="phoneNumberInput" placeholder="Enter your Contact Number" required oninput="restrictToNumbers(this)" value="<?php echo $contact; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <h6 class="mt-3 mb-2" style="color: #F7931E;">Address</h6>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="houseNo" class="form-label">House/Building No.</label>
                                        <input class="form-control" type="text" name="houseNo" placeholder="Enter House/Building No." required value="<?php echo $houseNo; ?>">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="street" class="form-label">Street Name</label>
                                        <input class="form-control" type="text" name="street" placeholder="Enter Street Name" required value="<?php echo $street; ?>">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="village" class="form-label">Village/District</label>
                                        <input class="form-control" type="text" name="village" placeholder="Enter Villag/District" value="<?php echo $village; ?>">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="City" class="form-label">City</label>
                                        <input type="text" class="form-control" name="city" placeholder="City of Pasig" value="City of Pasig" disabled>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <label for="barangay" class="form-label">Barangay</label>
                                    <select name="barangay" class="form-control" required>
                                        <option value="" disabled>Select your barangay</option>
                                        <option value="Bagong Ilog" <?php if ($barangay === "Bagong Ilog") echo "selected"; ?>>Bagong Ilog</option>
                                        <option value="Bagong Katipunan" <?php if ($barangay === "Bagong Katipunan") echo "selected"; ?>>Bagong Katipunan</option>
                                        <option value="Bambang" <?php if ($barangay === "Bambang") echo "selected"; ?>>Bambang</option>
                                        <option value="Buting" <?php if ($barangay === "Buting") echo "selected"; ?>>Buting</option>
                                        <option value="Caniogan" <?php if ($barangay === "Caniogan") echo "selected"; ?>>Caniogan</option>
                                        <option value="Dela Paz" <?php if ($barangay === "Dela Paz") echo "selected"; ?>>Dela Paz</option>
                                        <option value="Kalawaan" <?php if ($barangay === "Kalawaan") echo "selected"; ?>>Kalawaan</option>
                                        <option value="Kapasigan" <?php if ($barangay === "Kapasigan") echo "selected"; ?>>Kapasigan</option>
                                        <option value="Kapitolyo" <?php if ($barangay === "Kapitolyo") echo "selected"; ?>>Kapitolyo</option>
                                        <option value="Malinao" <?php if ($barangay === "Malinao") echo "selected"; ?>>Malinao</option>
                                        <option value="Manggahan" <?php if ($barangay === "Manggahan") echo "selected"; ?>>Manggahan</option>
                                        <option value="Maybunga" <?php if ($barangay === "Maybunga") echo "selected"; ?>>Maybunga</option>
                                        <option value="Oranbo" <?php if ($barangay === "Oranbo") echo "selected"; ?>>Oranbo</option>
                                        <option value="Palatiw" <?php if ($barangay === "Palatiw") echo "selected"; ?>>Palatiw</option>
                                        <option value="Pinagbuhatan" <?php if ($barangay === "Pinagbuhatan") echo "selected"; ?>>Pinagbuhatan</option>
                                        <option value="Pineda" <?php if ($barangay === "Pineda") echo "selected"; ?>>Pineda</option>
                                        <option value="Rosario" <?php if ($barangay === "Rosario") echo "selected"; ?>>Rosario</option>
                                        <option value="Sagad" <?php if ($barangay === "Sagad") echo "selected"; ?>>Sagad</option>
                                        <option value="San Antonio" <?php if ($barangay === "San Antonio") echo "selected"; ?>>San Antonio</option>
                                        <option value="San Joaquin" <?php if ($barangay === "San Joaquin") echo "selected"; ?>>San Joaquin</option>
                                        <option value="San Jose" <?php if ($barangay === "San Jose") echo "selected"; ?>>San Jose</option>
                                        <option value="San Miguel" <?php if ($barangay === "San Miguel") echo "selected"; ?>>San Miguel</option>
                                        <option value="San Nicolas" <?php if ($barangay === "San Nicolas") echo "selected"; ?>>San Nicolas</option>
                                        <option value="Santa Cruz" <?php if ($barangay === "Santa Cruz") echo "selected"; ?>>Santa Cruz</option>
                                        <option value="Santa Lucia" <?php if ($barangay === "Santa Lucia") echo "selected"; ?>>Santa Lucia</option>
                                        <option value="Santa Rosa" <?php if ($barangay === "Santa Rosa") echo "selected"; ?>>Santa Rosa</option>
                                        <option value="Santo Tomas" <?php if ($barangay === "Santo Tomas") echo "selected"; ?>>Santo Tomas</option>
                                        <option value="Santolan" <?php if ($barangay === "Santolan") echo "selected"; ?>>Santolan</option>
                                        <option value="Sumilang" <?php if ($barangay === "Sumilang") echo "selected"; ?>>Sumilang</option>
                                        <option value="Ugong" <?php if ($barangay === "Ugong") echo "selected"; ?>>Ugong</option>
                                    </select>
                                </div>


                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="postal" class="form-label">Postal Code</label>
                                        <input class="form-control" type="text" name="postal" id="postalInput" placeholder="Enter your Postal Code" oninput="restrictToNum(this)" required value="<?php echo $postal; ?>">
                                        <span class="note" style="display: none; color: red;">Please enter a valid 4-digit
                                            postal code without symbols or letters.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row gutters">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="d-flex justify-content-end" style="margin-top: 20px;">
                                        <button type="submit" name="update" class="btn btn-primary" style="margin-left: 10px; background-color: #F7931E; border-color: #F7931E;">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form> <!-- End of the form -->
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