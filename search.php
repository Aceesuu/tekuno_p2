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
    <title>Kat & Ren Construction Supply</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/logoo.ico">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- third party css -->
    <link href="assets/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css">
    <!-- third party css end -->

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
    <link href="css/dashccc.css" rel="stylesheet"/>
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
                        <br>
                    <!-- Search Bar -->
                    <div class="topnav-search">
    <form action="search.php" method="get">
        <div class="search-bar">
            <input type="text" name="query" id="search-input" placeholder="Search...">
            <input type="hidden" name="original-query" id="original-query">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
</div>



<ul class="list-unstyled topbar-menu float-end mb-0">

<li class="dropdown notification-list" style="display: flex; justify-content: center; align-items: center;">
 <!-- Add to Home link -->
 <a class="nav-link" href="dashboard-customer.php">
    <i class="mdi mdi-home-outline" style="font-size: 28px;"></i>
  </a>
</li>

    <li class="dropdown notification-list">
        <!-- Add to Cart link -->
        <a class="nav-link" href="addcart.php" style="display: flex; justify-content: center; align-items: center;">
            <i class='uil uil-shopping-cart-alt' style="font-size: 27px;"></i>
            <span id="cart-count" class="red-number">0</span>
        </a>
    </li>

    <li class="dropdown notification-list">
        <!-- Add to proof link -->
        <a class="nav-link" href="order_customer.php" style="display: flex; justify-content: center; align-items: center;">
            <i class="mdi mdi-inbox-multiple" style="font-size: 27px;"></i>
        </a>
    </li>

    <li class="dropdown notification-list">
        <!-- Add to proof link -->
        <a class="nav-link" href="proof_customer.php" style="display: flex; justify-content: center; align-items: center;">
            <i class="dripicons-wallet" style="font-size: 26px;"></i>
        </a>
    </li>


  <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="dripicons-bell noti-icon" style="display: flex; justify-content: center; align-items: flex-end; margin-top: 8px;"></i>
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
<a class="nav-link dropdown-toggle nav-user arrow-none me-0 custom-bg-color" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="position: relative; top: -10px;">
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
 <?php
                if (isset($_GET['query'])) {
                    $searchQuery = $_GET['query'];

                    // Modify the SQL query to filter products based on the search query
                    $sql = "SELECT * FROM tb_product WHERE name LIKE '%$searchQuery%'";

                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            echo '<div class="container">';
                            echo '<br><div class="search-results" style="display: inline; white-space: nowrap;">Search results for: ' . $searchQuery . '<br></div>';
                            echo '<section class="products">';
                            echo '<div class="box-container">';

                            while ($row = mysqli_fetch_assoc($result)) {
                                $product_id = $row['product_id'];
                                $product_name = $row['name'];
                                $product_price = $row['price'];

                                // Display products as before (you can reuse your existing product listing code)
                                echo '<div class="box">';
                                echo '<a href="product_detail.php?product_id=' . $product_id . '">';
                                echo '<img src="uploaded_img/' . $row['image'] . '" alt="' . $product_name . '">';
                                echo '</a>';
                                echo '<div class="details">';
                                echo '<h3>';
                                echo '<a href="product_detail.php?product_id=' . $product_id . '">' . $product_name . '</a>';
                                echo '</h3>';
                                echo '<div class="price">₱' . $product_price . '</div>';
                                echo '</div>';
                                echo '<form action="product_detail.php" method="get">';
                                echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
                                echo '<input type="submit" class="btn" value="View Product" name="add_to_cart" style="text-align: center;">';
                                echo '</form>';
                                echo '</div>';
                            }

                            echo '</div>';
                            echo '</section>';
                            echo '</div>';
                        } else {
                            echo '<div class="container">';
                                echo '<br><div class="search-results" style="display: inline; white-space: nowrap;">No result products found: ' . $searchQuery . '<br></div>';
                            echo '</div>';
                        }
                    } else {
                        echo 'Error in the database query.';
                    }
                }
                ?>

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

    <div class="rightbar-overlay"></div>
    <!-- /End-bar -->

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

    <script>
        // Sample data for search results
        let products = [];

        // Function to retrieve products from the server
        function fetchProducts() {
            fetch('get_products.php') // Replace 'get_products.php' with the actual path to your PHP script
                .then(response => response.json())
                .then(data => {
                    // Store the retrieved products in the 'products' variable
                    products = data;
                })
                .catch(error => console.error('Error fetching products: ', error));
        }

        // Call the function to fetch products when the page loads
        fetchProducts();

        function filterSearch(query) {
            const searchResults = document.getElementById('searchResults');

            // Clear previous results
            searchResults.innerHTML = '';

            if (query.trim() !== "") {
                // Show the search results container
                searchResults.style.display = 'block';

                // Filter and display matching items
                const filteredProducts = products.filter(product => product.toLowerCase().includes(query.toLowerCase()));
                filteredProducts.forEach(product => {
                    const resultItem = document.createElement('div');
                    resultItem.classList.add('search-result-item');
                    resultItem.textContent = product;

                    // Add a click event to select the item
                    resultItem.addEventListener('click', () => {
                        document.getElementById('searchInput').value = product;
                        searchResults.style.display = 'none';
                        // You can add navigation or other actions here
                    });

                    searchResults.appendChild(resultItem);
                });
            } else {
                // Hide the search results container if the input is empty
                searchResults.style.display = 'none';
            }
        }
    </script>

<script>
    // Get the search query from the URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const queryParam = urlParams.get("query");

    // Set the input field's value if the query parameter is present
    if (queryParam) {
        const searchInput = document.getElementById("search-input");
        const originalQuery = document.getElementById("original-query");

        searchInput.value = queryParam;
        originalQuery.value = queryParam;
    }
</script>

    <script>
        $(document).ready(function() {
            $('.category').click(function() {
                var category = $(this).data('category-name');

                // Remove the 'active-category' class from all categories
                $('.category').removeClass('active-category');

                // Add the 'active-category' class to the clicked category
                $(this).addClass('active-category');

                $.ajax({
                    url: 'filter_products.php',
                    type: 'POST',
                    data: {
                        category: category
                    },
                    success: function(data) {
                        $('.box-container').html(data);
                    }
                });
            });
        });
    </script>

</body>

</html>