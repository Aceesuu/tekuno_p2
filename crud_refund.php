<?php
include 'mysql_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accept'])) {
        $refund_id = $_POST['refund_id'];

        // Update the status to 'accept' in the database
        $update_query = "UPDATE `tb_refund` SET `status` = 'Accept' WHERE `refund_id` = $refund_id";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            echo "Status updated successfully";
            header("Location: refund_admin.php"); // Redirect to refund_admin.php
            exit();
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['update_status'])) {
        $refund_id = $_POST['update_p_id'];
        $message = $_POST['message'];

        // Update the status to 'decline' and save the decline message in the database
        $update_query = "UPDATE `tb_refund` SET `status` = 'Decline', `message` = '$message' WHERE `refund_id` = $refund_id";
        $result = mysqli_query($conn, $update_query);

        if ($result) {
            echo "Status updated successfully";
            header("Location: refund_admin.php"); // Redirect to refund_admin.php
            exit();
        } else {
            echo "Error updating status: " . mysqli_error($conn);
        }
    }
} else {
    header("Location: index.php"); // Redirect to the main page if accessed directly
    exit();
}
?>