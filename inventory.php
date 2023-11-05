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
    <title>Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/home_logo.ico">

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
                         <span class="account-position">Admin/Cashier</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
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
                                    <li class="breadcrumb-item">Products</a></li>
                                    <li class="breadcrumb-item active">List of Products</li>
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
                                    <div class="col-sm-4">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Purchase</button>
                                    </div>
                                </div>

                                <!-- Add Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Purchase</h5>
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

                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>New Quantity</th>
                                                <th>Date Added</th>
                                                <th style="width: 85px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $select_products = mysqli_query($conn, "SELECT * FROM `tb_product` WHERE new_qty > 0");
                                            if (mysqli_num_rows($select_products) > 0) {
                                                while ($row = mysqli_fetch_assoc($select_products)) {
                                            ?>
                                                    <tr>

                                                        <td><?php echo $row['product_id']; ?></td>
                                                        <td><?php echo $row['name']; ?></td>
                                                        <td><?php echo $row['new_qty']; ?></td>
                                                        <td><?php echo $row['purchase_date']; ?></td>
                                                        <td class="table-action">

                                                            <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $row['product_id']; ?>" style="background-color: #5C5470;">
                                                                <i class="mdi mdi-clipboard-edit"></i> Edit
                                                            </button>

                                                            <button class="btn btn-danger btn-rounded delete-btn" data-product-id="<?php echo $row['product_id']; ?>"><i class="mdi mdi-delete"></i> Delete</button>
                                                        </td>

                                                        <!-- Edit MODAL -->
                                                        <div class="modal fade" id="edit_<?php echo $row['product_id']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="ModalLabel">Edit Product</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="POST" action="crud.php" enctype="multipart/form-data">
                                                                            <input type="hidden" name="update_p_id" value="<?php echo $row['product_id']; ?>">
                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Product Name</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="update_p_name" value="<?php echo $row['name']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Description</label>
                                                                                <div class="col-sm-10">
                                                                                    <textarea class="form-control" name="update_p_desc"><?php echo $row['prod_desc']; ?></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Price</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="update_p_price" value="<?php echo $row['price']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Quantity</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="update_p_qty" value="<?php echo $row['qty']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <div class="col-sm-10">
                                                                                    <?php
                                                                                    $existing_image = $row['image'];
                                                                                    if (!empty($existing_image)) {
                                                                                        echo '<img src="uploaded_img/' . $existing_image . '" alt="Existing Image" style="max-width: 100px;">';
                                                                                    } else {
                                                                                        echo 'No existing image available.';
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <div class="col-sm-10">
                                                                                    <input type="file" class="form-control" name="update_p_image" value="<?php echo $row['image']; ?>">
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" name="update_product" class="btn btn-primary"> Update</a>
                                                                            </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                };
                                            } else {
                                                echo "<div class='empty'>no product added</div>";
                                            };
                                                ?>
                                                <!--DELETE MODAL -->
                                                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this product?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <!-- Add a form and submit the form when the user confirms deletion -->
                                                                <form id="deleteForm" method="POST" action="crud.php">
                                                                    <input type="hidden" id="product_id" name="product_id" value="">
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