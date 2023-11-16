s<?php
session_start(); // Start the session
include("mysql_connect.php");

if (isset($_POST['add_user'])) {
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $pass = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];


    $insert_user = $conn->prepare("INSERT INTO tb_admin (lastName, firstName, middleName, gender, contact, email, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_user->bind_param("ssssssss", $lastName, $firstName, $middleName, $gender, $contact, $email, $pass, $role);

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
$update_admin_id = $_POST['update_admin_id'];
$update_lastName = $_POST['update_lastName'];
$update_firstName = $_POST['update_firstName'];
$update_middleName = $_POST['update_middleName'];
$update_gender = $_POST['update_gender'];
$update_contact = $_POST['update_contact'];
$update_role = $_POST['update_role'];
$update_email = $_POST['update_email'];


$update_user = $conn->prepare("UPDATE `tb_admin` SET lastName = ?, firstName = ?, middleName = ?, gender = ?, contact = ?, email = ?, role = ? WHERE admin_id = ?");
$update_user->bind_param("sssssssi", $update_lastName, $update_firstName, $update_middleName, $update_gender, $update_contact, $update_email, $update_role, $update_admin_id);

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
if (isset($_POST['admin_id'])) {
$admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
var_dump($_POST['admin_id']);

$query = "DELETE FROM tb_admin WHERE admin_id='$admin_id'";
$query_run = mysqli_query($conn, $query);

if ($query_run) {
$_SESSION['message'] = "User Deleted Successfully";
header('location: admins.php');
} else {
$_SESSION['message'] = "User Not Deleted";
}
}
}

?>