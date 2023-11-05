<?php

include("mysql_connect.php");

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
?>