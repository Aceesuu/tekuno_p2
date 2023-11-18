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

    $sql = "SELECT * FROM tb_admin WHERE admin_id = $admin_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row["firstName"];
        $lastName = $row["lastName"];
        $middleName = $row['middleName'];
        $gender = $row['gender'];
        $contact = $row['contact'];
    } else {
        echo "No data found";
    }
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Profile</title>
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
                        <a href="dashboard-order.php" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span> Dashboard </span>
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
                                            <a href="role_order.php">Order Details</a>
                                        </li>
                                           <li>
                                            <a href="role_order_onsite.php">Order Onsites</a>
                                        </li>
                                        <li>
                                            <a href="role_order_history.php">Order History</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>

                        <div class="clearfix"></div>

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
                         
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                         =


                                </div>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <?php
                                    $user_image = $admin_data['image'];
                                    if (!empty($user_image)) {
                                        // Display the user's image if available
                                        echo '<img src="uploaded_img/' . $user_image . '" alt="user" class="rounded-circle" style="height: auto;">';
                                    } else {
                                        // Display a default avatar image when no user image is available
                                        echo '<img src="assets/images/profile.jpg" alt="Default Avatar" class="rounded-circle" style="height: auto;">';
                                    }
                                    ?>
                                </span>
                                <span>
                                    <span class="account-user-name"><?php echo $admin_data['firstName'] ?></span>
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
                <!-- end page title -->

                <div class="container">
                    <div class="row gutters">
                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                            <div class="card h-27">
                                <div class="card-body">
                                    <div class="account-settings">
                                        <div class="user-profile">
                                            <div class="user-avatar">
                                                <?php
                                                $user_image = $admin_data['image'];

                                                if (!empty($user_image)) {
                                                    // Display the user's image if available
                                                    echo '<img src="uploaded_img/' . $user_image . '" alt="user">';
                                                } else {
                                                    // Display a default avatar image when no user image is available
                                                    echo '<img src="assets/images/profile.jpg" alt="Default Avatar">';
                                                }

                                                ?>
                                            </div>
                                            <h5 class="user-name"><?php echo $admin_data['firstName'] . ' ' . $admin_data['lastName']; ?></h5>
                                            <form action="update_profile_admin.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                                                <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $row['admin_id']; ?>">
                                                    <i class="mdi mdi-clipboard-edit"></i> Edit
                                                </button>
                                                <!-- Edit MODAL -->
                                                <div class="modal fade" id="edit_<?php echo $row['admin_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="ModalLabel">Edit Profile</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="update_profile_admin.php" enctype="multipart/form-data">
                                                                    <input type="hidden" name="update_p_id" value="<?php echo $row['admin_id']; ?>">
                                                                    <div class="mb-3 row">
                                                                        <div class="col-sm-10">
                                                                            <?php
                                                                            $existing_image = $row['image'];
                                                                            if (!empty($existing_image)) {
                                                                                echo '<img src="uploaded_img/' . $existing_image . '" alt="Existing Image" style="max-width: 100px;">';
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
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" name="update_user" class="btn btn-primary">Update</button>
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
                                    <form method="post" action="update_profile_admin.php">
                                        <div class="row gutters">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                <h6 class="mb-2" style="color: #F7931E;">Personal Details</h6>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                                <input type="hidden" name="update_u_id" value="<?php echo $row['admin_id']; ?>">
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
                                                    <small class="form-text text-muted">If you do not have a middle name, you can leave this field blank.</small>
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
                                                    <label for="contact" class="form-label">Contact Number</label>
                                                    <input class="form-control" type="text" name="contact" id="phoneNumberInput" placeholder="Enter your Contact Number" required oninput="restrictToNumbers(this)" value="<?php echo $contact; ?>">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                    </div>
                    <!-- container -->

                </div>
                <!-- content -->

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
        <script src="assets/js/vendor/apexcharts.min.js"></script>
        <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
        <!-- third party js ends -->

        <!-- demo app -->
        <script src="assets/js/pages/demo.dashboard.js"></script>
        <!-- end demo js-->
</body>

</html>