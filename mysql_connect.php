<?php
/*
------------------------------------------------------------------------------------------------------
Script Name: mysql_connect.php
Author:  TEKUNO
Description: To connect to the MySQL server and database
------------------------------------------------------------------------------------------------------
*/
$username ="root";
$password="";
$database="tekuno_p2";
$conn = mysqli_connect("localhost",$username,$password);
mysqli_select_db($conn, $database) or die ("Unable to select database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
