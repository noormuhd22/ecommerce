<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: loginpage.php");
    exit();
}

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    include 'connection.php';


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
    header("Location: adminsports.php");
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
 
    .btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Modal styling */
.modal-content {
    border-radius: 8px;
}

.modal-header {
    background-color: #007bff;
    color: #fff;
    border-bottom: none;
}

.modal-title {
    font-size: 18px;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: none;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.btn-primary.modal-button {
    margin-top: 10px;
}
img{
    height:80px;
    width:100px;
    border-radius:5px;
}
</style>
<body>

<?php include 'adminnavbar.php'; ?>

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
                
        <!-- Placeholder for equal spacing -->
                
            </tr>
            <tr>
            <td>
                    <p>Total Price: <?php echo $row_order["totalprice"]; ?></p>
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
        <button type="button" id="changeStatusButton" class="btn btn-primary">
         Change Status
       </button>
       </div>

        <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
       <div class="modal-dialog" role="document">
       <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
       </div>
       <div class="modal-body">
      
        <form method="post" action="updatestatus.php">
        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        <div class="form-group">
            <label for="status">New Status:</label>
            <select class="form-control" id="status" name="status">
                <option value="0">Not Updated</option>
              <option value="1">Processing</option>
              <option value="2">Shipped</option>
              <option value="3">Out of Delivery</option>
              <option value="4">Delivered</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
      </div>
    </div>
  </div>
</div>




<script>
    
    function displayModal() {
        $('#changeStatusModal').modal('show');
    }

   
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('changeStatusButton').addEventListener('click', displayModal);
    });
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    var loggedInUser = sessionStorage.getItem('loggedInUser'); 
    if (loggedInUser) {
        document.getElementById("loggedInUser").innerHTML = loggedInUser;
    }
</script>
</body>
</html>
