<?php
// Include the database connection details
include('mysql_connect.php');

// Fetch products from the database
$sql = "SELECT name FROM tb_product";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row["name"];
    }
}

// Close the database connection
$conn->close();

// Output products as JSON
header('Content-Type: application/json');
echo json_encode($products);
?>
