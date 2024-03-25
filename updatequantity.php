<?php
// update_quantity.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID and new quantity from POST request
$productId = $_POST['productId'];
$newQuantity = $_POST['quantity'];

// Update quantity in the database
$sql = "UPDATE cart SET quantity = '$newQuantity' WHERE productid = '$productId'";

if ($conn->query($sql) === TRUE) {
    // Quantity updated successfully
    echo json_encode(array('success' => true));
} else {
    // Error occurred while updating quantity
    echo json_encode(array('success' => false, 'error' => $conn->error));
}

$conn->close();
?>
