<?php
session_start(); // Start the session
include("mysql_connect.php");
if (isset($_POST['add_user'])) {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Check if the user being added is an admin (you can modify this condition as needed)
    $is_admin = 1; // Set is_admin to 1 for admin users, or 0 for regular users

    $insert_user = $conn->prepare("INSERT INTO tb_user (lastName, firstName, middleName, gender, contact, email, password, confirm, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_user->bind_param("ssssssssi", $lastName, $firstName, $middleName, $gender, $contact, $email, $pass, $confirm, $is_admin);

    // Execute the prepared statement
    if ($insert_user->execute()) {
        $message[] = 'Admin user added successfully'; // You can modify the success message
        header('location: admins.php');
    } else {
        $message[] = 'Could not add the user';
        header('location: admins.php');
    }

    // Close the prepared statement
    $insert_user->close();
}

//UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_user'])) {
        // Handle user update
        $update_user_id = $_POST['update_user_id'];
        $update_lastName = $_POST['update_lastName'];
        $update_firstName = $_POST['update_firstName'];
        $update_middleName = $_POST['update_middleName'];
        $update_gender = $_POST['update_gender'];
        $update_contact = $_POST['update_contact'];
        $update_email = $_POST['update_email'];

        $update_user = $conn->prepare("UPDATE `tb_user` SET lastName = ?, firstName = ?, middleName = ?, gender = ?, contact = ?, email = ? WHERE user_id = ?");
        $update_user->bind_param("ssssssi", $update_lastName, $update_firstName, $update_middleName, $update_gender, $update_contact, $update_email, $update_user_id);
        if ($update_user->execute()) {
            $message = 'User updated successfully';
            header('location: admins.php');
        } else {
            $message = 'User could not be updated';
            header('location: admins.php');
        }

        $update_user->close();
    }
}

//DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        var_dump($_POST['user_id']);

        $query = "DELETE FROM tb_user WHERE user_id='$user_id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "User Deleted Successfully";
            header('location: admins.php');
        } else {
            $_SESSION['message'] = "User Not Deleted";
            header('location: admins.php');
        }
    }
}

?>