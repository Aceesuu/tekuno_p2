<?php
session_start();
include "mysql_connect.php";

// Use $_GET to retrieve the product_id from the query string
$product_id = $_GET['product_id'];

// Update the "new_qty" and "purchase_date" in the "tb_product" table
$sql = "SELECT * FROM product_variation WHERE product_id = $product_id";

// Perform the SQL query and fetch the results
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    $variations = array();

    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result)) {
        $variations[] = $row;
    }

    // Convert the array to JSON and echo the response
    echo json_encode($variations);
} else {
    // Handle the case where the query fails
    echo json_encode(['error' => 'Failed to fetch data']);
}

// Close the database connection
mysqli_close($conn);
?>