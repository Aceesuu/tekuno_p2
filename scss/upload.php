<?php
include "mysql_connect.php";
if (isset($_POST['update_user'])) {
    $update_p_id = $_POST['update_p_id']; // Retrieve the user ID

    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];

    $update_p_image_folder = 'user_profile_img/' . $update_p_image;

    $update_query = mysqli_query($conn, "UPDATE `tb_user` SET image = '$update_p_image' WHERE user_id = '$update_p_id'");

    if ($update_query) {
        move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
        $message = 'Profile image updated successfully';
        header('location:user_profile.php');
    } else {
        $message = 'Profile image could not be updated';
        header('location:user_profile.php');
    }
}

if (isset($_POST['update'])) {
    $update_u_id = $_POST['update_u_id'];
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $gender = $_POST['gender'];
    $bdate = $_POST['bdate'];
    $contact = $_POST['contact'];
    $barangay = $_POST['barangay'];
    $postal = $_POST['postal'];
    $houseNo = $_POST['houseNo'];
    $street = $_POST['street'];
    $village = $_POST['village'];

    $update_query = mysqli_query($conn, "UPDATE `tb_user` SET lastName = '$lastName', firstName = '$firstName', middleName = '$middleName', gender = '$gender', bdate = '$bdate', contact = '$contact', barangay = '$barangay', postal = '$postal', houseNo = '$houseNo', street = '$street', village = '$village' WHERE user_id = '$update_u_id'");

    // Check if the update was successful
    if ($update_query) {
        // Redirect to user_profile.php
        header("Location: user_profile.php");
        exit(); // Make sure to exit to prevent further execution of the script
    } else {
        // Handle the case where the update failed
        echo "Update failed. Please try again.";
    }
}
