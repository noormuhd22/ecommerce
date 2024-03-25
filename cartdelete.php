<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecommerce";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $productId = $_POST['productId'];

    $sql = "DELETE FROM cart WHERE productid = '$productId'";

    if ($conn->query($sql) === TRUE) {
 
    header("location:cart.php");
    } else {
        
        echo "Error deleting product: " . $conn->error;
    }

    $conn->close();
} else {
  
    echo "Invalid request";
}
?>
