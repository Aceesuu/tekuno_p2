<?php
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
    $selectedRole = $_POST['role'];

    if ($selectedRole === 'Admin') {
        $role = "Admin";
    } elseif ($selectedRole === 'Inventory Manager') {
        $role = "Inventory Manager";
    } elseif ($selectedRole === 'Order Manager') {
        $role = "Order Manager";
    } elseif ($selectedRole === 'Customer Management') {
        $role = "Customer Management";
    } else {
        $role = "Unknown"; // Handle the case where the role is not recognized
    }

    $insert_user = $conn->prepare("INSERT INTO tb_admin (lastName, firstName, middleName, gender, contact, email, username, password, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_user->bind_param("sssssssss", $lastName, $firstName, $middleName, $gender, $contact, $email, $username, $pass, $role);

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
    if (isset($_POST['update_admin_id'])) {
        $update_admin_id = $_POST['update_admin_id'];
        $update_lastName = $_POST['update_lastName'];
        $update_firstName = $_POST['update_firstName'];
        $update_middleName = $_POST['update_middleName'];
        $update_gender = $_POST['update_gender'];
        $update_contact = $_POST['update_contact'];
        $update_email = $_POST['update_email'];
        $role = $_POST['update_role']; // Assuming role is passed as an integer

        // Prepare the SQL statement
        $update_user = $conn->prepare("UPDATE `tb_admin` SET lastName = ?, firstName = ?, middleName = ?, gender = ?, contact = ?, email = ?, role = ? WHERE admin_id = ?");

        // Check if the statement was prepared successfully
        if ($update_user === false) {
            die('Error in preparing the SQL statement: ' . $conn->error);
        }

        // Bind parameters
        $update_user->bind_param("ssssisii", $update_lastName, $update_firstName, $update_middleName, $update_gender, $update_contact, $update_email, $role, $update_admin_id);

        // Execute the statement
        if ($update_user->execute()) {
            $message = 'User updated successfully';
            header('location: admins.php');
        } else {
            $message = 'User could not be updated';
            header('location: admins.php');
        }

        // Close the prepared statement
        $update_user->close();
    }
}


//DELETE
  if (isset($_POST['admin_id'])) {
        $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);

        $query = "DELETE FROM tb_admin WHERE admin_id='$admin_id'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['message'] = "Admin Deleted Successfully";
        } else {
            $_SESSION['message'] = "Admin Not Deleted";
        }
    }

    header('location: admins.php'); // Redirect back to the appropriate page

?>