<?php
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];

    // Include the PHP file to establish database connection
    include 'connection.php';

    // Update the order status in the orders table
    $sql_update = "UPDATE orders SET status = $new_status WHERE orderid = $order_id";

    if ($conn->query($sql_update) === TRUE) {
        
        header("Location: adminorders.php");
        exit();
    } else {
        echo "Error updating order status: " . $conn->error;
    }
} else {
    // Redirect back to the admin panel if the request method is not POST or the required parameters are not set
    header("Location: adminsports.php");
    exit();
}
?>
