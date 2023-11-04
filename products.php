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
    <title>Products</title>
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
                    <img src="assets/images/logo1.png" alt="" height="97">
                </span>
                <span class="logo-sm" style="background-color: #212A37;">
                    <img src="assets/images/logo1.png" alt="" height="47">
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
                                    <a href="category.php">Category</a>
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
                                <h4 class="page-title">Products</h4>
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
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">Add Product</button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table dt-responsive nowrap w-100" style="width:100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="all">Product ID</th>
                                                    <th>Product Image</th>
                                                    <th>Product Name</th>
                                                    <th>Category</th>
                                                    <th>Supplier Price</th>
                                                    <th>Unit Price</th>
                                                    <th>Starting Quantity</th>
                                                    <th>New Stock</th>
                                                    <th>Total Quantity</th>
                                                    <th>Stocks</th>
                                                    <th style="width: 85px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $select_products = mysqli_query($conn, "SELECT * FROM `tb_product`");

                                                if (mysqli_num_rows($select_products) > 0) {
                                                    $total_quantity = 0;
                                                    while ($row = mysqli_fetch_assoc($select_products)) {
                                                        if ($row['qty'] == 0 && $row['new_qty'] > 0) {
                                                            $row['qty'] = $row['new_qty'];
                                                            $row['new_qty'] = 0;
                                                        }
                                                        $stock_status = ($row['qty'] <= 0) ? 'Out of Stock' : 'Instock';
                                                        $badge_class = ($stock_status == 'Instock') ? 'badge-success-lighten' : 'badge-danger-lighten';
                                                ?>
                                                        <tr>
                                                            <td><?php echo $row['product_id']; ?></td>
                                                            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['category']; ?></td>
                                                            <td>₱<?php echo $row['supplier_price']; ?></td>
                                                            <td>₱<?php echo $row['price']; ?></td>
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
                                                            <td class="table-action">
                                                                <a href="admin_product_detail.php?product_id=<?php echo $row['product_id']; ?>" class="btn btn-info rounded style=" background-color: #3085C3; color: white;">
                                                                    <i class="mdi mdi-eye"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-dark btn-rounded" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $row['product_id']; ?>" style="background-color: #5C5470;">
                                                                    <i class="mdi mdi-clipboard-edit"></i>
                                                                </button>
                                                                <button class="btn btn-danger btn-rounded delete-btn" data-product-id="<?php echo $row['product_id']; ?>"><i class="mdi mdi-delete"></i></button>
                                                            </td>
                                                        </tr>

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

                                                                            <div class="mb-3">
                                                                                <label for="category" class="form-label">Category</label>
                                                                                <select name="update_category" class="form-control" required>
                                                                                    <option value="" disabled>Select Category</option>

                                                                                    <?php
                                                                                    // Query the database
                                                                                    $sql = "SELECT * FROM tb_category";
                                                                                    $result = $conn->query($sql);

                                                                                    // Loop through the results
                                                                                    while ($category = $result->fetch_assoc()) {
                                                                                        $category_name = $category['category_name'];
                                                                                        $selected = ($row['category'] === $category_name) ? 'selected' : '';
                                                                                        echo '<option value="' . $category_name . '" ' . $selected . '>' . $category_name . '</option>';
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Description</label>
                                                                                <div class="col-sm-10">
                                                                                    <textarea class="form-control" name="update_p_desc"><?php echo $row['prod_desc']; ?></textarea>
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Supplier Price</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="update_sup" value="<?php echo $row['supplier_price']; ?>">
                                                                                </div>
                                                                            </div>

                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label">Unit Price</label>
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
                                                                                <label class="col-sm-2 col-form-label">Expiry Date</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="date" class="form-control" name="update_exp_date" value="<?php echo $row['exp_date']; ?>">
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
                                                    }
                                                }
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
                                            </tbody>
                                        </table>

                                        <!-- Add Modal -->
                                        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="crud.php" method="post" class="add-product-form" enctype="multipart/form-data">

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Product Name</label>
                                                                <input type="text" name="p_name" class="form-control" placeholder="Enter the product name" required>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Category</label>
                                                                <select name="p_cat" class="form-control" required>
                                                                    <option value="" disabled selected>Select Category</option>
                                                                    <?php
                                                                    $sql = "SELECT category_name FROM tb_category";
                                                                    $result = mysqli_query($conn, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        echo '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Description</label>
                                                                <textarea class="form-control" placeholder="Description" name="p_desc" style="height: 100px"></textarea>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="simpleinput" class="form-label">Supplier Price</label>
                                                                        <input type="number" min="1" value="" name="supplier_price" class="form-control" placeholder="Enter the supplier price" style="width: 90px;" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="simpleinput" class="form-label">Price</label>
                                                                        <input type="number" min="1" name="p_price" class="form-control" style="width: 90px;" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Quantity</label>
                                                                <input type="number" min="1" name="p_qty" class="form-control" required>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="simpleinput" class="form-label">Expiry Date</label>
                                                                <input type="date" class="form-control" name="exp_date">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="example-fileinput" class="form-label">Choose an Image:</label>
                                                                <input type="file" id="example-fileinput" name="p_image" accept="image/png, image/jpg, image/jpeg" class="form-control" required>
                                                            </div>
                                                            <div id="image-preview">
                                                                <img id="preview-image" src="#" alt="Image Preview">
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