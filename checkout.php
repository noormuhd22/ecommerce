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
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
   table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
      
        @media screen and (max-width: 600px) {
            table {
                width: 100%;
            }

            th, td {
                padding: 8px;
            }

            .container {
                width: 100%;
                padding: 10px;
            }
        }
</style>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <h2>Order Summary</h2>

        
        
        <?php
      
        
    




        // Database connection
        $servername = "localhost"; 
        $username = "root";
        $password = "";
        $dbname = "ecommerce";
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_er );
        }
    
     
        $userId = $_SESSION['user_id']; 
        $sql = "SELECT * FROM cart WHERE userid = '$userId'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th> Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th> 
                   
                </tr>
                <?php
                $totalPrice = 0; 
                while ($row = $result->fetch_assoc()):
                    $subtotal = $row['price'] * $row['quantity'];
                    $totalPrice += $subtotal; 
                    ?>
                    <tr>
                        <td><?php echo $row['productname']; ?></td>
                        <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['productname']; ?>" style="max-width: 100px;"></td> <!-- Display image -->
                        <td id="price_<?php echo $row['productid']; ?>"><?php echo $row['price']; ?></td>
                        <td>
                        <div class="input-group">
       
                       <input type="text" class="form-control" id="quantity_<?php echo $row['productid']; ?>" value="<?php echo $row['quantity']; ?>" readonly>
        
                         </div>
                        </td>
                        <td class="subtotal" id="subtotal_<?php echo $row['productid']; ?>"><?php echo $subtotal; ?></td> 
                      
                    </tr>
                    
                <?php endwhile; ?>
                
                <tr>
                    <td colspan="4">Total</td>
                    <td id="totalPrice"><?php echo $totalPrice; ?></td> 
                </tr>
            </table>
            <?php else: ?>
        <p>Cart is empty</p>
    <?php endif; ?>
     


        <h4>Delivery Details</h4>

        <div class="form-group">
            
        <form action="process_order.php" method="post">
        <div class="form-group">
                 <label for="Name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="state">state:</label>
                <input type="text" class="form-control" id="state" name="state" required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <div class="form-group">
                <label for="pincode">Pincode:</label>
                <input type="tel" class="form-control" id="pincode" name="pincode" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number:</label>
                <input type="tel" class="form-control" id="mobile" name="mobile" required>
            </div>

            
            <a href="javascript:void(0)" row-productid="<?php echo $row['productid'];?>" row-productname="<?php echo $row['productname'];?>" row-amount="<?php echo $totalPrice?>" class="btn btn-primary buynow">Placeorder</a>
        </form>
    </div>












    <!-- Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(".buynow").click(function(event) {
    var name = $("#name").val();
    var address = $("#address").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var pincode = $("#pincode").val();
    var mobile = $("#mobile").val();
   
    // Regular expressions for mobile number and pincode validation
    var mobileRegex = /^[0-9]{10}$/;
    var pincodeRegex = /^[0-9]{6}$/;
    var cityRegex = /^[A-Za-z\s]+$/;
    var stateRegex = /^[A-Za-z\s]+$/;

    // Validation checks
    if (name && address && state && city && pincode && mobile && mobileRegex.test(mobile) && pincodeRegex.test(pincode)) {
        var amount = $(this).attr('row-amount');   
        var productname = $(this).attr('row-productname');

        var options = {
            "key": "rzp_test_zyzUFvfeyBQKdL",
            "amount": amount * 100,
            "name": "Sports Shop",
            "description": productname, 
            "image": "logo.jpg",
            "handler": function (response) {
                var paymentid = response.razorpay_payment_id;
                $.ajax({
                    url: "payment-process.php",
                    type: "POST",
                    data: {
                        payment_id: paymentid,
                        totalprice: amount,
                        name: name,
                        address: address,
                        state: state,
                        city: city,
                        pincode: pincode,
                        mobile: mobile
                    },
                    success: function(finalresponse) {
                        if (finalresponse == 'done') {
                            window.location.href = "success.php";
                        } else {
                            alert('Please check console.log to find error');
                            console.log(finalresponse);
                        }
                    }
                });
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        
        var rzp1 = new Razorpay(options);
        rzp1.open();
    } else {
        alert("Please fill out all the fields correctly before proceeding to payment.");
    }

    event.preventDefault();
});
</script>

    

</body>
</html>
