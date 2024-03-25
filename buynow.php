<?php 
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: loginpage.php");
    exit();
}
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
    <?php include 'navbar.php'; ?> <!-- Assuming you have a navbar.php file -->

    <div class="container mt-4">
        <h2>Order Summary</h2>

        
        <?php
   
      

        // Retrieve cart items from the database based on user ID
        if(isset($_POST['productId'])) {
            $productId = $_POST['productId'];
            $stmt = $conn->prepare("SELECT * FROM product WHERE id = ?");
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th> Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th> <!-- New column for total price -->
                    </tr>
                    <?php
                   $totalPrice = 0; // Initialize total price variable
                   while ($row = $result->fetch_assoc()):
                       $subtotal = $row['price'] ; // Calculate subtotal for each item
                       $totalPrice += $subtotal; // Add subtotal to total price
                        ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" style="max-width: 100px;"></td> <!-- Display image -->
                            <td id="price_<?php echo $row['id']; ?>"><?php echo $row['price']; ?></td>
                            <td>
                     
                            </td>
                            <td class="subtotal" id="subtotal_<?php echo $row['id']; ?>"><?php echo $subtotal; ?></td> <!-- Display subtotal -->
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="4">Total</td>
                        <td id="totalPrice"><?php  echo $totalPrice; ?></td> <!-- Display total price -->
                    </tr>
                </table>
            <?php else: ?>
                <p>Cart is empty</p>
            <?php endif;
        } ?>
     


        <h4>Delivery Details</h4>

        <div class="form-group">
            
        <form action="process_order.php" method="post">
        <div class="form-group">
                 <label for="Name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <input type="hidden" name="productId" id="productId" value="<?php echo $productId; ?>">
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

            <!-- Payment mode selection -->
         

            <!-- Submit button -->
            
            <a href="javascript:void(0)" row-productid="<?php echo $row['id'];?>" row-productname="<?php echo $row['name'];?>" row-amount="<?php echo $totalPrice?>" class="btn btn-primary buynow">Placeorder</a>
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
    var amount = $(this).attr('row-amount');   
    var name = $("#name").val();
    var address = $("#address").val();
    var state = $("#state").val();
    var city = $("#city").val();
    var pincode = $("#pincode").val();
    var mobile = $("#mobile").val();
    var productId = $("#productId").val();
   
    var productname=$(this).attr('row-productname');	
    
    var options = {
        "key": "rzp_test_zyzUFvfeyBQKdL",
        "amount": amount * 100,
        "name": "Sports Shop",
        "description": productname, // This variable is not defined, you may need to pass it as a parameter or define it
        "image": "logo.jpg",
        "handler": function (response) {
            var paymentid = response.razorpay_payment_id;
            $.ajax({
                url: "payment_buynow.php",
                type: "POST",
                data: {
                    payment_id: paymentid,
                    totalprice: amount,
                    name: name,
                    address: address,
                    state: state,
                    city: city,
                    pincode: pincode,
                    mobile: mobile,
                   productId:productId
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
    event.preventDefault(); // Use event.preventDefault() to prevent default anchor tag behavior
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
