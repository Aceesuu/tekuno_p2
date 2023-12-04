<?php
session_start();
include("mysql_connect.php");

// Function to log actions to the audit trail
function logAction1($conn, $user_id, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $query = "INSERT INTO audit_user (user_id, action) VALUES ('$user_id', '$action')";
    mysqli_query($conn, $query);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve user data
    $query = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
    $user_result = mysqli_query($conn, $query);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);

        // Log the logout action to the audit trail
        $action = "User {$user_data['user_id']} logged out";
        logAction1($conn, $user_data['user_id'], $action);
    } else {
        // Handle the case where user data couldn't be retrieved
        $error_message = "Error: Unable to retrieve user data.";
    }
}

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: index.php');
exit;
?>