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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];

    if ($action === 'toShip') {
        // Update the order status to 'Accepted' in the tb_orders table
        $update_query = mysqli_query($conn, "UPDATE `tb_order` SET order_status = 'To Ship' WHERE order_id = '$orderId'");
    } elseif ($action === 'toReceive') {
        // Update the order status to 'Rejected' in the tb_orders table
        $update_query = mysqli_query($conn, "UPDATE `tb_order` SET order_status = 'To Receive' WHERE order_id = '$orderId'");
    } elseif ($action === 'decline') {
        // Update the order status to 'Declined' in the tb_orders table
        $update_query = mysqli_query($conn, "UPDATE `tb_order` SET order_status = 'Declined' WHERE order_id = '$orderId'");
    } else {
        echo "Invalid action.";
        exit();
    }

    if ($update_query) {
        echo "Order $action successfully.";
    } else {
        echo "Error: Unable to $action the order.";
    }
} else {
    echo "Invalid request method.";
}
