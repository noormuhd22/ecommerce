
<?php
session_start();


if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
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
    <title>Items Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            width: 900px;
            margin-left:auto;
            margin-right:auto;



        }
        table img{
           max-width:400px;
            max-height:200px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .col{
            float:left;
  
        }
        
        h2{
            text-align:center;
            margin-top:50px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?> 
    <h2>Orders</h2>
   
   

   
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Adress</th> 
                <th>State</th> 
                <th>City</th>
                <th>Pincode</th>
                <th>Total Price</th>
                <th>Payment ID</th>
                <th>Order Number</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>action</th>

            </tr>
        </thead>
        <tbody>
            <?php
            // Include the PHP file to fetch data from the database
            include 'connection.php';
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM orders  WHERE user_id = $user_id ORDER BY orderid DESC";
        $result = $conn->query($sql);

            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["mobile"]."</td>";
                echo "<td>".$row["address"]."</td>";
                echo "<td>".$row["state"]."</td>";
                echo "<td>".$row["city"]."</td>";
                echo "<td>".$row["pincode"]."</td>";
                echo "<td>".$row["totalprice"]."</td>";
                echo "<td>".$row["payment_id"]."</td>";
                echo "<td>".$row["orderid"]."</td>";
                echo "<td>".$row["added_date"]."</td>";
                echo "<td>";
            // Conditional statement for status
            if ($row["status"] == 1) {
                echo "Processing";
            }  else if($row["status"] == 2){
               echo"Shipped"; 
            } else if($row["status"] == 3){
                echo"Out of Delivery";
            }else if($row["status"] == 4){
               echo"Delivered";
            } else {
                echo "Not Updated";
            }
            echo "</td>";
                echo "<td><a href='vieworder.php?order_id=".$row["orderid"]."' class='btn btn-primary'>View</a></td>";


                echo "</tr>";
            }
            ?>
        </tbody>
    </table>



</body>
</html>
