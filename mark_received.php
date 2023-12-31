<?php
session_start(); // Start the session
include "mysql_connect.php";

// Check if the order_id is provided in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Check if the order exists and its status is "To Receive"
    $select_order = mysqli_query($conn, "SELECT * FROM `tb_order` WHERE `order_id` = $order_id AND `order_status` = 'To Receive'");

    if (mysqli_num_rows($select_order) > 0) {
        // Update the order status to "Received"
        $update_query = "UPDATE `tb_order` SET `order_status` = 'Complete' WHERE `order_id` = $order_id";
        if (mysqli_query($conn, $update_query)) {
            // Order was successfully marked as received
            echo "Order #{$order_id} has been marked as received.";
        } else {
            // Failed to update the order status
            echo "Error: Failed to mark the order as received. Please try again.";
        }
    } else {
        // Order not found or not eligible for marking as received
        echo "Error: Order not found or not eligible for marking as received.";
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
