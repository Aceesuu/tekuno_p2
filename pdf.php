<?php
include("mysql_connect.php");
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$sql = "SELECT order_id, name, price, order_status FROM tb_order";
$result = mysqli_query($conn, $sql);

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Order</title>
    <style>
        h2{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            text-align: center;
        }
        table{
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        td, th{
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Sales Order</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $html .= '<tr>
        <td>' . $row['order_id'] . '</td>
        <td>' . $row['name'] . '</td>
        <td>' . number_format($row['price'], 2) . '</td>
        <td>' . $row['order_status'] . '</td>
    </tr>';
}

$html .= '</tbody>';
$html .= '</table>';
$html .= '</body>';
$html .= '</html>';

$dompdf = new Dompdf;
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('sales.pdf', ['Attachment' => 0]);
?>



			
		