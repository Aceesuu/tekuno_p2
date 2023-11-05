<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$server = "srv483.hstgr.io";
$username = "u377814293_capstone";
$password = "T3kun0_Spac3";
$database = "u377814293_tekuno_p2";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
