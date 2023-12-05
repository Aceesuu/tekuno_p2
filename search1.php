<!-- third party css -->
    <link href="assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script defer src="script.js"></script>

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- DataTables Buttons JavaScript -->
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script defer src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">

    <link rel="stylesheet" href="css/order1.css">

<?php
session_start();
include "mysql_connect.php";


// Retrieve start and end dates from the request
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];

// Create SQL query to fetch data within the specified date range
$sql = "SELECT user_id, name, price, qty, subtotal FROM tb_order WHERE order_date BETWEEN '$startDate' AND '$endDate'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display data in a table
    echo "<center><h4>Orders between $startDate and $endDate</h4></center>";
    echo "<table id='example' class='table dt-responsive nowrap w-100'>";
    echo "<thead class='table-light'><tr><th>User ID</th><th>Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th></tr></thead>";

    $grandTotal = 0; // Initialize grand total variable

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["price"] . "</td>";
        echo "<td>" . $row["qty"] . "</td>";
        echo "<td>" . $row["subtotal"] . "</td>";
        echo "</tr>";

        // Accumulate sub_total to calculate grand total
        $grandTotal += $row["subtotal"];
    }

     // Display a row for the grand total
    echo "<tr>";
    echo "<td colspan='4'><strong>Grand Total</strong></td>";
    echo "<td><strong>$grandTotal</strong></td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "No results found";
}

?>
