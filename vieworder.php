<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: adminlogin.php");
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Include the PHP file to establish database connection
    include 'connection.php';

    // Fetch delivery information from the orders table
    $sql_order = "SELECT * FROM orders WHERE orderid = $order_id";
    $result_order = $conn->query($sql_order);

    if (!$result_order) {
        echo "Error fetching order details: " . $conn->error;
        exit();
    }

    
    $sql_order_details = "SELECT * FROM orderdetails WHERE orderid = $order_id";
    $result_order_details = $conn->query($sql_order_details);

    if (!$result_order_details) {
        echo "Error fetching order details: " . $conn->error;
        exit();
    }
} else {
    header("Location: loginpage.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>View Order</title>
</head>
<style>
    h3 {
        text-align: center;
        padding: 20px;
        font-size: 30px;
        color: #4b16ad;
    }
    h4 {
        color: #4b16ad;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    table th {
        background-color: #f2f2f2;
    }
    img{
        height:80px;
        width:100px;
        border-radius:3px;
    }
    .totalprice{
        color:green;
    }
</style>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h4>View Order Details</h4>

    <?php if ($result_order->num_rows > 0) {
        $row_order = $result_order->fetch_assoc(); ?>
        <h3>Customer Details (Order No:<?php echo $row_order["orderid"] ?>)</h3>
        <table>
            <tr>
                <th>Customer Information</th>
             
                
            </tr>
            <tr>
                <td>
                    <p>Name: <?php echo $row_order["name"]; ?></p>
                    <p>Phone Number: <?php echo $row_order["mobile"]; ?></p>
                    <p>Address: <?php echo $row_order["address"]; ?></p>
                    <p>State: <?php echo $row_order["state"]; ?></p>
                    <p>City: <?php echo $row_order["city"]; ?></p>
                    <p>Pincode: <?php echo $row_order["pincode"]; ?></p>
                </td>
            
            </tr>
        </table>

        <h3>Order Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Img</th>
                    <th>Quantity</th>
                    <th>Price</th>

                </tr>
            </thead>
            <tbody>
                <?php while ($row_order_details = $result_order_details->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row_order_details["productname"]; ?></td>
                        <td><img src="<?php echo $row_order_details["image"]; ?>" alt="img"></td> 
                        <td><?php echo $row_order_details["quantity"]; ?></td>
                        <td><?php echo $row_order_details["price"]; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No order found.</p>
    <?php } ?>

    <table>
            <tr>
                
        
                
            </tr>
            <tr>
            <td>
                    <p class="totalprice">Total Price: <?php echo $row_order["totalprice"]; ?></p>
                    <p>Payment ID: <?php echo $row_order["payment_id"]; ?></p>
                    <p>Order Date: <?php echo $row_order["added_date"]; ?></p>
                    <p>Order Status: <?php   if ($row_order["status"] == 1) {
                echo "Processing";
            }  else if($row_order["status"] == 2){
               echo"Shipped"; 
            } else if($row_order["status"] == 3){
                echo"Out of Delivery";
            }else if($row_order["status"] == 4){
               echo"Delivered";
            } else {
                echo "Not Updated";
            } ?></p>
                </td>
            
            </tr>
        </table>
</div>



</body>
</html>
