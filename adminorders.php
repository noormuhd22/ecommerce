
<?php
session_start();


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <title>Items Table</title>
    <style>

body {
            overflow-x: hidden;
            overflow-y: auto; 
           
        }


        
        table {
            width: 100%;
            border-collapse: collapse;
            width:900px;
            margin-left:auto;
            margin-right:auto;
             
            border-radius:25px;
            overflow:hidden;
            border: 2px solid #dddddd;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);



        }
        table img{
           max-width:400px;
            max-height:200px;
        }
        th, td {
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
/* Style the form container */
form {
   float:right;
    padding: 20px;
 
    border-radius: 5px;
    
}

/* Style the label */
label {
    font-weight: bold;
}

/* Style the input field */
input[type="text"] {
    width: 200px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Style the button */
button[type="submit"] {
    padding: 8px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

/* Hover effect on button */
button[type="submit"]:hover {
    background-color: #0056b3;
}


        
    </style>
</head>
<body>

<?php include 'adminnavbar.php'; ?> 
    <h2>Orders</h2>
   
   

    <table id="myTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>User ID</th>
            <th>Phone Number</th>
            <th>Address</th> 
            <th>State</th> 
            <th>City</th>
            <th>Pincode</th>
            <th>Total Price</th>
            <th>Payment ID</th>
            <th>Order Number</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Include the PHP file to fetch data from the database
        include 'connection.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

         
   
        $sql = "SELECT * FROM orders ORDER BY orderid DESC";

$result = $conn->query($sql);
       

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["user_id"]."</td>";
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
            
            echo "<td><a href='adminvieworder.php?order_id=".$row["orderid"]."' class='btn btn-primary'>View</a></td>";

            echo "</tr>";
        }
        ?>
    </tbody>
</table>


<script>
  $(document).ready( function () {
    $('#myTable').DataTable();
  });
</script>
    <script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>
</body>
</html>
