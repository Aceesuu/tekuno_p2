<?php
session_start();
include "mysql_connect.php";

// Retrieve start and end dates from the request
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Create SQL query to fetch data within the specified date range
$sql = "SELECT o.user_id, o.name, o.price, p.supplier_price, o.qty, (o.price - p.supplier_price) AS profit 
        FROM tb_order o
        JOIN tb_product p ON o.product_id = p.product_id
        WHERE o.order_date BETWEEN '$startDate' AND '$endDate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display data in a table
    echo "<center><h4>Profit Report between $startDate and $endDate</h4></center>";
    echo "<table id='example' class='table dt-responsive nowrap w-100'>";
    echo "<thead class='table-light'><tr><th>User ID</th><th>Name</th><th>Price</th><th>Supplier Price</th><th>Quantity</th><th>Profit</th></tr></thead>";

    $totalProfit = 0; // Initialize total profit variable

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["supplier_price"] . "</td>";
        echo "<td>" . $row["qty"] . "</td>";
        echo "<td>" . $row["profit"] . "</td>";
        echo "</tr>";

        // Accumulate profit to calculate total profit
        $totalProfit += $row["profit"];
    }

    // Display a row for the total profit
    echo "<tr>";
    echo "<td colspan='5'><strong>Total Profit</strong></td>";
    echo "<td><strong>$totalProfit</strong></td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "No results found";
}

?>
