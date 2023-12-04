<?php
session_start(); //session
include("mysql_connect.php"); //connection

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM tb_admin WHERE admin_id = '$admin_id'"; //session from admin
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
    <title>Order Onsite</title> <!-- title ng tab -->
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

                    <ul class="side-nav">
                        <ul class="side-nav">
                            <li class="side-nav-item">
                                <a href="#sidebarEcommerceOrder" aria-expanded="false" aria-controls="sidebarEcommerceOrder" class="side-nav-link">
                                    <i class="uil-shopping-cart-alt"></i>
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
                        </ul>


                        <div class="clearfix"></div>
                    </ul>
            </div>
            <!-- Sidebar -left -->
        </div>

        <!-- ============================================================== -->
        <!-- TOP NAVBAR -->
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

                        <!-- PROFILE -->
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
                                <a href="logout_admin.php" class="dropdown-item notify-item">
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

                <!-- ============================================================== -->
                <!-- Start Page Content here -->
                <!-- ============================================================== -->

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
                                        <li class="breadcrumb-item active">Order Onsite</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Order Onsite</h4>
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
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="mdi mdi-basket me-1"></i>Add New Order</button>
                                            </div>
                                        </div><!-- end col-->
                                    </div>

                                    <div class="table-responsive">
                                        <table id="example" class="table dt-responsive nowrap w-100" style="width:100%">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Order Date</th>
                                                    <th>Product Name</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                    <th>Grand Total</th>
                                                    <th>Invoice</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $select_products = mysqli_query($conn, "SELECT * FROM `order_onsite` ORDER BY order_date DESC");
                                                $grand_total = 0;
                                                $total = 0;
                                                $sub_total = 0;
                                                $discounted_price = 0;
                                                $discount_rate = 0.03;
                                                if (mysqli_num_rows($select_products) > 0) {
                                                    while ($row = mysqli_fetch_assoc($select_products)) {
                                                        // Convert the order_date timestamp to a DateTime object
                                                        $orderDateTime = new DateTime($row['order_date']);
                                                        // Format the date in the desired format
                                                        $formattedDate = $orderDateTime->format('F d Y');
                                                        $formattedTime = $orderDateTime->format('h:i A');

                                                        $subtotal = $row['subtotal'];
                                                        $discounted_price = ($subtotal >= 5000) ? $subtotal * (1 - $discount_rate) : $subtotal;

                                                        $tax_rate = 0.12;
                                                        $tax = $discounted_price * $tax_rate;

                                                        // Calculate the grand total without shipping fee
                                                        $grand_total = $discounted_price + $tax;

                                                        // Calculate the discount
                                                        $discount = ($subtotal >= 5000) ? $subtotal - $discounted_price : 0;
                                                ?>
                                                        <tr>
                                                            <td><b>Order #<?php echo $row['order_id']; ?></b></td>
                                                            <td><?php echo $formattedDate; ?> <small class="text-muted"><?php echo $formattedTime; ?></small></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['qty']; ?></td>
                                                            <td><?php echo $subtotal; ?></td>
                                                            <td><?php echo number_format($grand_total, 2); ?></td>
                                                            <td> <a href="role_invoice_onsite.php?order_id=<?php echo $row['order_id']; ?>" class="btn btn-sm btn-primary">View Invoice</a>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </tbody>
                                        </table>

                                        <!-- Add Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="role_crud_order_onsite.php" method="post" class="add-product-form" enctype="multipart/form-data">

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Product Name</label>
                                                                <select name="p_name" id="p_name" class="form-control" required>
                                                                    <option value="" disabled selected>Select product</option>
                                                                    <?php
                                                                    $sql = "SELECT name, price, qty, product_id FROM tb_product";
                                                                    $result = mysqli_query($conn, $sql);
                                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                                        $productName = $row['name'];
                                                                        echo '<option value="' . $row['name'] . '" data-price="' . $row['price'] . '" data-qty="' . $row['qty'] . '" data-id="' . $row['product_id'] . '">' . $row['name'] . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3">
                                                                <input type="hidden" name="price" id="price" class="form-control" readonly>
                                                            </div>

                                                            <label for="avail_quan" class="form-label">Available Quantity</label>
                                                            <input type="text" name="avail_quan" id="avail_quan" class="form-control" readonly>

                                                            <label for="p_qty" class="form-label">Quantity</label>
                                                            <input type="number" name="p_qty" id="p_qty" class="form-control" required>

                                                            <div class="mb-3">
                                                                <label for="simpleinput" class="form-label">Variation</label>
                                                                <select name="variation" id="variation" class="form-control" required>
                                                                    <input type="hidden" name="variation_price" id="variation_price" value="">
                                                                    <option value="" disabled selected>Select product variation</option>
                                                                </select>
                                                            </div>

                                                            <label for="total_price" class="form-label">Total Price</label>
                                                            <input type="text" id="total_price" class="form-control" readonly>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" id="submit" name="add_product" class="btn btn-primary">Add Order</button>
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
                    //FROM DATATABLE LIBRARY
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
                    // MAG UPDATE YUNG TOTAL PRICE
                    function updateTotalPrice(variationPrice) {
                        var price = parseFloat($('#price').val()) || 0; // retrieve the price
                        var qty = parseInt($('#p_qty').val()) || 0; // retrieve the qty
                        var varPrice = parseFloat($('#variation_price').val()) || 0; // Retrieve variationPrice from the input

                        var total_price = (price * qty) + varPrice; // compute total price (price product + qty (add varPrice if meron))
                        $('#total_price').val(total_price.toFixed(2)); // display total price into decimal
                    }

                    $(document).ready(function() {
                    function checkAvailabilityAndEnableButton() {
                        var qty = parseInt($('#avail_quan').val()) || 0;
                        var requestedQty = parseInt($('#p_qty').val()) || 0;

                        if (qty <= 0) {
                            $('#submit').prop('disabled', true);
                            alert('Selected product is out of stock.');
                        } else if (requestedQty > qty) {
                            $('#submit').prop('disabled', true);
                            alert('Requested quantity exceeds available stock.');
                        } else {
                            $('#submit').prop('disabled', false);
                        }
                    }

                        $('#p_name').on('change', function() { // if change of product name
                            var selectedOption = $(this).find('option:selected'); // kung anong product
                            if (selectedOption) {
                                var price = selectedOption.data('price'); // retrieve the price
                                var qty = selectedOption.data('qty'); // retrieve the qty
                                var product_id = selectedOption.val(); // Get the product ID

                                if (qty > 0) {
                                    $('#price').val(price); // display price but hidden
                                    $('#avail_quan').val(qty); // display qty
                                    $('#product_id').val(product_id); // display product but hidden
                                    updateTotalPrice(); // call function of updateTotalPrice
                                } else {
                                    alert('Selected product is out of stock.'); // Show an alert if the available quantity is 0
                                    $('#price').val(''); // clear
                                    $('#avail_quan').val('');
                                    $('#total_price').val('');
                                    $('#product_id').val('');
                                }
                            } else {
                                $('#price').val(''); // clear
                                $('#avail_quan').val('');
                                $('#total_price').val('');
                                $('#product_id').val('');
                            }

                            checkAvailabilityAndEnableButton(); // check and enable/disable the button

                            $('#p_qty').on('input', function() {
                                updateTotalPrice();
                                checkAvailabilityAndEnableButton(); // check and enable/disable the button
                            });

                            // ID
                            var productId = selectedOption.data('id'); // retrieve product_id

                            $.ajax({
                                type: 'GET', // ACTION
                                url: 'product_variation.php', // retrieve this page it includes the database
                                data: {
                                    product_id: productId
                                },
                                success: function(response) {
                                    // Assuming the response is in JSON format
                                    var variations = JSON.parse(response);
                                    console.log(variations)
                                    // Assuming you have a select element with id "variation"
                                    var selectElement = $('#variation');

                                    // Clear existing options
                                    selectElement.empty();

                                    // Add the default option
                                    var defaultOption = '<option disabled selected>Select Variation</option>';
                                    selectElement.append(defaultOption);

                                    // Build and append new options to the select element
                                    variations.forEach(function(row) {
                                        var option = '<option value="' + row.variation_id + '" data-variation_price="' + row.price + '" data-supplier="' + row.supplier_price + '">' + row.variation + '</option>';
                                        selectElement.append(option);
                                    });

                                    $('#variation').on('change', function() {
                                        var selectedOption = $(this).find('option:selected'); // selected variation

                                        if (selectedOption) {
                                            var variationPrice = selectedOption.data('variation_price'); // retrieve variation price
                                            $('#variation_price').val(variationPrice); // output
                                            console.log(variationPrice)
                                            updateTotalPrice(variationPrice); // function with variation price
                                        } else {
                                            var variationPrice = ''; // clear
                                        }
                                    });
                                },
                                error: function(error) {
                                    console.error('Error fetching data: ', error); // display error
                                }
                            });
                        });

                        $('#variation').on('change', function() {
                            var selectedOption = $(this).find('option:selected');

                            if (selectedOption) {
                                var variationPrice = selectedOption.data('variation_price');
                                $('#variation_price').val(variationPrice);
                                console.log(variationPrice);
                            } else {
                                $('#variation_price').val(''); // Clear variationPrice if no option is selected
                            }

                            updateTotalPrice();
                        });

                        $('#p_qty').on('input', function() {
                            updateTotalPrice();
                        });
                    });
                </script>



</body>

</html>