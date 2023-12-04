<?php
include "mysql_connect.php";
if (isset($_POST['update_user'])) {
    $update_p_id = $_POST['update_p_id']; // Retrieve the user ID

    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'uploaded_img/' . $update_p_image;

    $update_query = mysqli_query($conn, "UPDATE `tb_admin` SET image = '$update_p_image' WHERE admin_id = '$update_p_id'");

    if ($update_query) {
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        $message = 'Profile image updated successfully';
        header('location: inventory_profile_admin.php');
    } else {
        $message = 'Profile image could not be updated';
        header('location: inventory_profile_admin.php');
    }
}

if (isset($_POST['update'])) {
    $update_u_id = $_POST['update_u_id'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];

    $update_query = mysqli_query($conn, "UPDATE `tb_admin` SET lastName = '$lastName', firstName = '$firstName', middleName = '$middleName', gender = '$gender', contact = '$contact' WHERE admin_id = '$update_u_id'");

    // Check if the update was successful
    if ($update_query) {
        header("Location: inventory_profile_admin.php");
        exit(); // Make sure to exit to prevent further execution of the script
    } else {
        echo "Update failed. Please try again.";
    }
}
?>