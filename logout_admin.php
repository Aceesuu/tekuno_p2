<?php
session_start();
include("mysql_connect.php");

// Function to log actions to the audit trail for users
function logUserAction($conn, $user_id, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $query = "INSERT INTO audit_user (user_id, action) VALUES ('$user_id', '$action')";
    mysqli_query($conn, $query);
}

// Function to log actions to the audit trail for admins
function logAdminAction($conn, $admin_id, $role, $action)
{
    $action = mysqli_real_escape_string($conn, $action);
    $role = mysqli_real_escape_string($conn, $role);
    $query = "INSERT INTO audit_trail (admin_id, role, action) VALUES ('$admin_id', '$role', '$action')";
    mysqli_query($conn, $query);
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve user data
    $query = "SELECT * FROM tb_user WHERE user_id = '$user_id'";
    $user_result = mysqli_query($conn, $query);

    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $user_data = mysqli_fetch_assoc($user_result);

        // Log the logout action to the audit trail for users
        $action = "User {$user['user_id']} logged out";
        logUserAction($conn, $user_id, $action);
    } else {
        // Handle the case where user data couldn't be retrieved
        $error_message = "Error: Unable to retrieve user data.";
    }

    // Destroy the user session
    unset($_SESSION['user_id']);
}

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];

    // Retrieve admin data
    $query = "SELECT * FROM tb_admin WHERE admin_id = '$admin_id'";
    $admin_result = mysqli_query($conn, $query);

    if ($admin_result && mysqli_num_rows($admin_result) > 0) {
        $admin_data = mysqli_fetch_assoc($admin_result);

        // Log the logout action to the audit trail for admins
        $action = "logged out";
        logAdminAction($conn, $admin_id, $admin_data['role'], $action);
    } else {
        // Handle the case where admin data couldn't be retrieved
        $error_message = "Error: Unable to retrieve admin data.";
    }

    // Destroy the admin session
    unset($_SESSION['admin_id']);
}

// Redirect to the login page
header('Location: index.php');
exit;
?>