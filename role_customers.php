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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Customers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

    <!-- third party css -->
    <link href="assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css">
    <link href="assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- third party css end -->

    <link rel="stylesheet" href="text/design.css">

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
                   <img src="assets/images/logo1.png" alt="" height="100">
                </span>
                <span class="logo-sm">
                    <img src="assets/images/logo1.png" alt="" height="47">
                </span>
            </a>
            <br> <br>

            <div class="h-100" id="leftside-menu-container" data-simplebar="">

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>
                    <li class="side-nav-item">
                        <a href="dashboard-role-customer.php" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <ul class="side-nav">

                        <li class="side-nav-item">
                            <a href="customers.php" class="side-nav-link">
                                <i class="dripicons-user-group"></i>
                                <span> Customers </span>
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
                                <span>
                                    <span class="account-user-name"><?php echo $user_data['firstName'] ?></span>
                                    <span class="account-position">Customer Manager</span>
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
                                        <li class="breadcrumb-item active">Customers</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Customers</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Customer
                                            </button>
                                        </div>

                                        <!-- Add Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="crud_user.php" method="post" class="add-product-form" enctype="multipart/form-data">

                                                            <div class="mb-3">
                                                                <label for="lastname" class="form-label"><i class="fas fa-user"></i>Last Name</label>
                                                                <input class="form-control" type="text" name="lastName" id="lastNameInput" placeholder="Enter your Last Name" oninput="restrictToLetters(this)" required>
                                                                <span class="note" style="display: none; color: red;">Please enter letters only</span>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="firstname" class="form-label">First Name</label>
                                                                <input class="form-control" type="text" name="firstName" id="firstNameInput" placeholder="Enter your First Name" oninput="restrictToLetters(this)" required>
                                                                <span class="note" style="display: none; color: red;">Please enter letters only.</span>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="middlename" class="form-label">Middle Name</label>
                                                                <input class="form-control" type="text" name="middleName" id="middleNameInput" placeholder="Enter your Middle Name" oninput="restrictToLetters(this)">
                                                                <span class=" note" style="display: none; color: red;">Please enter letters only.</span>
                                                                <small class="form-text text-muted">If you do not have a middle name, you can leave this field blank.</small>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="gender" class="form-label">Gender</label>
                                                                <select name="gender" class="form-control" required>
                                                                    <option value="" disabled selected>Select your gender</option>
                                                                    <option value="Female">Female</option>
                                                                    <option value="Male">Male</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="contact" class="form-label">Contact Number</label>
                                                                <input class="form-control" type="text" name="contact" id="phoneNumberInput" placeholder="Enter your Contact Number" required oninput="restrictToNumbers(this)" maxlength="11">
                                                                <span class="note" style="display: none; color: red;">Please enter a valid 11-digit number without symbols or letters.</span>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                                                <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="password" class="form-label"><i class="fas fa-lock"></i> Password</label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                                                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fas fa-eye"></i></button>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="confirmPassword" class="form-label"><i class="fas fa-lock"></i> Confirm Password</label>
                                                                <div class="input-group">
                                                                    <input type="password" class="form-control" name="confirm" id="confirmPassword" placeholder="Confirm your password" required>
                                                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword"><i class="fas fa-eye"></i></button>
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="add_user" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="all" style="width: 20px;">
                                                            <div class="form-check">
                                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                            </div>
                                                        </th>
                                                        <th class="all">User ID</th>
                                                        <th> Image</th>
                                                        <th>Full Name</th>
                                                        <th>Contact</th>
                                                        <th>Email</th>
                                                        <th>Address</th>
                                                        <th style="width: 85px;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $select_users = mysqli_query($conn, "SELECT * FROM `tb_user` WHERE is_admin = 0");
                                                    if (mysqli_num_rows($select_users) > 0) {
                                                        while ($row = mysqli_fetch_assoc($select_users)) {
                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" class="form-check-input" id="customCheck2">
                                                                        <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                                    </div>
                                                                </td>
                                                                <td><?php echo $row['user_id']; ?></td>
                                                                <td>
                                                                    <?php
                                                                    if (!empty($row['image'])) {
                                                                        echo '<img src="uploaded_img/' . $row['image'] . '" height="100" alt="">';
                                                                    } else {
                                                                        echo '<img src="assets/images/profile.jpg" height="100" alt="Default Profile Picture">';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $row['firstName'] . ' ' . $row['lastName']; ?></td>
                                                                <td><?php echo $row['contact']; ?></td>
                                                                <td><?php echo $row['email']; ?></td>
                                                                <td><?php echo $row['houseNo'] . ' ' . $row['street'] . ' ' . $row['barangay']; ?></td>
                                                                <td class="table-action">
                                                                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#info_<?php echo $row['user_id']; ?>">
                                                                        <i class="uil-file-info-alt"></i>
                                                                    </button>

                                                                    <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $row['user_id']; ?>">
                                                                        <i class="mdi mdi-clipboard-edit"></i>
                                                                    </button>

                                                                    <button class="btn btn-danger btn-rounded delete-btn" data-user-id="<?php echo $row['user_id']; ?>"><i class="mdi mdi-delete"></i></button>
                                                                </td>

                                     <!-- Info MODAL -->
                                       <div class="modal fade" id="info_<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                           <div class="card text-center">
                                        <div class="card-body">
                                        <?php
                                          $existing_image = $row['image'];
                                            if (!empty($existing_image)) {
                                              echo '<img src="user_profile_img/' . $existing_image . '" alt="profile-image" class="rounded-circle avatar-lg img-thumbnail">';
                                                } else {
                                              echo 'No existing image available.';
                                                }
                                                ?>

                                        <h4 class="mb-0 mt-2"><?php echo $row['firstName'] . ' ' . $row['lastName']; ?></h4>
                                        <p class="text-muted font-14">Customer</p>

                                        <div class="text-start mt-3">

                                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2"><?php echo $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']; ?></span></p>

                                            <p class="text-muted mb-1 font-13"><strong>Gender :</strong> <span class="ms-2"><?php echo $row['gender']; ?></span></p>
                                            <p class="text-muted mb-1 font-13"><strong>Birthdate :</strong> <span class="ms-2"><?php echo $row['bdate']; ?></span></p>

                                            <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2"><?php echo $row['contact']; ?></span></p>

                                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 "><?php echo $row['email']; ?></span></p>

                                            <p class="text-muted mb-1 font-13"><strong>Address :</strong> <span class="ms-2"><?php echo $row['houseNo'] . ' ' . $row['street'] . ' ' . $row['barangay']; ?></span></p>
                                        </div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->
                            </div>
                         </div>

                                                                <!-- Edit MODAL -->
                                                                <div class="modal fade" id="edit_<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="ModalLabel">Edit Customer</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form method="POST" action="crud_user.php">
                                                                                    <input type="hidden" name="update_user_id" value="<?php echo $row['user_id']; ?>">

                                                                                    <div class="mb-3">
                                                                                        <label for="lastname" class="form-label"><i class="fas fa-user"></i>Last Name</label>
                                                                                        <input class="form-control" type="text" name="update_lastName" id="lastNameInput" placeholder="Enter your Last Name" oninput="restrictToLetters(this)" value="<?php echo $row['lastName']; ?>" required>
                                                                                        <span class="note" style="display: none; color: red;">Please enter letters only</span>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="firstname" class="form-label">First Name</label>
                                                                                        <input class="form-control" type="text" name="update_firstName" id="firstNameInput" placeholder="Enter your First Name" oninput="restrictToLetters(this)" value="<?php echo $row['firstName']; ?>" required>
                                                                                        <span class="note" style="display: none; color: red;">Please enter letters only.</span>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="middlename" class="form-label">Middle Name</label>
                                                                                        <input class="form-control" type="text" name="update_middleName" id="middleNameInput" placeholder="Enter your Middle Name" oninput="restrictToLetters(this)" value="<?php echo $row['middleName']; ?>">
                                                                                        <span class=" note" style="display: none; color: red;">Please enter letters only.</span>
                                                                                        <small class="form-text text-muted">If you do not have a middle name, you can leave this field blank.</small>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="gender" class="form-label">Gender</label>
                                                                                        <select name="update_gender" class="form-control" required>
                                                                                            <option value="" disabled>Select your gender</option>
                                                                                            <option value="Female" <?php if ($row['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                                                                                            <option value="Male" <?php if ($row['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                                                                                        </select>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="contact" class="form-label">Contact Number</label>
                                                                                        <input class="form-control" type="text" name="update_contact" id="phoneNumberInput" placeholder="Enter your Contact Number" required oninput="restrictToNumbers(this)" maxlength="11" value="<?php echo $row['contact']; ?>">
                                                                                        <span class="note" style="display: none; color: red;">Please enter a valid 11-digit number without symbols or letters.</span>
                                                                                    </div>

                                                                                    <div class="mb-3">
                                                                                        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                                                                        <input type="email" class="form-control" name="update_email" placeholder="Enter your email" required value="<?php echo $row['email']; ?>">
                                                                                    </div>

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                                <button type="submit" name="update_user" class="btn btn-primary"> Update</a>
                                                                                    </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        <?php
                                                        };
                                                    } else {
                                                        echo "<div class='empty'>no user added</div>";
                                                    };
                                                        ?>
                                                        <!-- DELETE MODAL -->
                                                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Are you sure you want to delete this user?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <!-- Add a form and submit the form when the user confirms deletion -->
                                                                        <form id="deleteForm" method="POST" action="crud_user.php">
                                                                            <input type="hidden" id="user_id" name="user_id" value="">
                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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

        <!-- third party js -->
        <script src="assets/js/vendor/jquery.dataTables.min.js"></script>
        <script src="assets/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="assets/js/vendor/dataTables.responsive.min.js"></script>
        <script src="assets/js/vendor/responsive.bootstrap5.min.js"></script>
        <script src="assets/js/vendor/dataTables.checkboxes.min.js"></script>

        <!-- third party js ends -->

        <!-- demo app -->
        <script src="assets/js/pages/demo.products.js"></script>
        <!-- end demo js-->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-o6bLTM2BjR41l/6t1Sss/OtX4Yp1p2qE6neGJ0wMmR8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha256-YozT52Tvl6FsThQz3DlF6b6t8zVf3DzA/0H3A6EiPPE=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js" integrity="sha384-Kay7B3Qj2TqpBMp7rN7R+JGzxp7F2bNQfDHxng5tQ8o66fwW0ueRdKp5l3kI33dM" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                $(".delete-btn").click(function() {
                    var user_id = $(this).data('user-id');
                    console.log("Delete button clicked with user_id: " + user_id); // Add this line
                    $("#user_id").val(user_id);
                    $('#deleteConfirmationModal').modal('show');
                });
            });
        </script>

        <script>
            const togglePasswordButton = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePasswordButton.querySelector('i').classList.toggle('fa-eye');
                togglePasswordButton.querySelector('i').classList.toggle('fa-eye-slash');
            });
        </script>

        <script>
            const toggleConfirmPasswordButton = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('confirmPassword');

            toggleConfirmPasswordButton.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);
                toggleConfirmPasswordButton.querySelector('i').classList.toggle('fa-eye');
                toggleConfirmPasswordButton.querySelector('i').classList.toggle('fa-eye-slash');
            });
        </script>

</body>

</html>