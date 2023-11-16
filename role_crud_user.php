<?php
session_start(); // Start the session
include("mysql_connect.php");

//USERRRR IN CUSTOMERS OF ADMIN
if (isset($_POST['add_user'])) {
$lastName = $_POST['lastName'];
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$gender = $_POST['gender'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$pass = $_POST['password'];
$confirm = $_POST['confirm'];

$insert_user = $conn->prepare("INSERT INTO tb_user (lastName, firstName, middleName, gender, contact, email, password, confirm) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$insert_user->bind_param("ssssssss", $lastName, $firstName, $middleName, $gender, $contact, $email, $pass, $confirm);

// Execute the prepared statement
if ($insert_user->execute()) {
$message[] = 'User added successfully';
header('location: customers.php');
} else {
$message[] = 'Could not add the user';
header('location: customers.php');
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
header('location: role_customers.php');
} else {
$message = 'User could not be updated';
header('location: role_customers.php');
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
header('location: role_customers.php');
} else {
$_SESSION['message'] = "User Not Deleted";
}
}
}

?>