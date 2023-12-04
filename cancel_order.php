<?php
session_start(); // Start the session
include "mysql_connect.php";

// Function to log actions to the audit trail
function logAction($conn, $user_id, $user_data, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $query = "INSERT INTO audit_user (user_id, action) VALUES ('$user_id', '$action')";
    mysqli_query($conn, $query);
}

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
} else {
    $error_message = "Error: Unable to retrieve user data.";
}

// Check if the order_id is provided in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Check if the order exists and its status is "To Ship"
    $select_order = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `order_id` = $order_id AND `order_status` = 'Pending'");

    if (mysqli_num_rows($select_order) > 0) {
        // Update the order status to "Cancelled"
        $update_query = "UPDATE `tb_order` SET `order_status` = 'Cancelled' WHERE `order_id` = $order_id";
        if (mysqli_query($conn, $update_query)) {
            // Order was successfully cancelled
            echo "Order #{$order_id} has been successfully cancelled.";
            logAction($conn, $user_id, $user_data, "User {$user_data['user_id']} Cancelled an order.");
        } else {
            // Failed to update the order status
            echo "Error: Failed to cancel the order. Please try again.";
        }
    } else {
        // Order not found or not eligible for cancellation
        echo "Error: Order not found or not eligible for cancellation.";
    }
} else {
    // No order_id provided in the URL
    echo "Error: Order ID not provided.";
}

// Close the database connection
mysqli_close($conn);

header("Location: order_customer.php");
exit(0);
?>
