<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();



if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: loginpage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
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

    // Get the product details from the form submission
    $userId = $_POST['userId'];
    $productId = $_POST['productId'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Insert the product into the user's cart in the database
    $sql = "INSERT INTO cart (userid, productid, productname, price, quantity,image) VALUES ('$userId', '$productId', '$name', '$price', '1','$image')";

    if ($conn->query($sql) === TRUE) {
        // Product added to cart successfully
        // Redirect back to the previous page or to the cart page
        header("location: cart.php");
        exit();
    } else {
        // Error occurred while adding product to cart
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    // Display cart table here
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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Shopping Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .material-symbols-outlined {
            color:red;
        }

        button {
            border:none;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

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
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2>Shopping Cart</h2>
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
        die("Connection failed: " . $conn->connect_error);
    }

    $userId = $_SESSION['user_id']; 
    $sql = "SELECT * FROM cart WHERE userid = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th> 
                <th>Action</th>
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
    <div class="input-group-prepend">
        <button class="btn btn-outline-secondary minus-btn" type="button" onclick="decrementQuantity(<?php echo $row['productid']; ?>)">-</button>
    </div>
    <input type="text" class="form-control" id="quantity_<?php echo $row['productid']; ?>" value="<?php echo $row['quantity']; ?>" readonly>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary plus-btn" type="button" onclick="incrementQuantity(<?php echo $row['productid']; ?>)">+</button>
    </div>
</div>
                    </td>
                    <td class="subtotal" id="subtotal_<?php echo $row['productid']; ?>"><?php echo $subtotal; ?></td> <!-- Display subtotal -->
                    <td>
                    <form id="deleteForm_<?php echo $row['productid']; ?>" action="cartdelete.php" method="post">
                   <input type="hidden" name="productId" value="<?php echo $row['productid']; ?>">
                     <button type="button" onclick="confirmDelete(<?php echo $row['productid']; ?>)"><span class="material-symbols-outlined">delete</span></button>
                   </form>

                    </td>
                </tr>
                
            <?php endwhile; ?>
            
            <tr>
                <td colspan="4">Total</td>
                <td id="totalPrice"><?php echo $totalPrice; ?></td> <!-- Display total price -->
            </tr>
        </table>
        <a href="checkout.php"><button class="btn btn-primary mt-3">Proceed to Checkout</button></a>
    <?php else: ?>
        <p>Cart is empty</p>
    <?php endif; ?>
</div>



<script>
    function confirmDelete(productId) {
    if (confirm("Are you sure you want to delete this item from your cart?")) {
        document.getElementById('deleteForm_' + productId).submit();
    }
}

</script>

<script>
    function updateQuantity(productId, newQuantity) {
       
        var formData = new FormData();
        formData.append('productId', productId);
        formData.append('quantity', newQuantity);

        fetch('updatequantity.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                
                updateTotalPrice(productId, newQuantity);
                updatePageTotalPrice();
            } else {
                
                console.error('Failed to update quantity');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function incrementQuantity(productId) {
        var quantityField = document.getElementById('quantity_' + productId);
        var currentQuantity = parseInt(quantityField.value);
        var newQuantity = currentQuantity + 1;
        quantityField.value = newQuantity;

        
        updateQuantity(productId, newQuantity);
    }

    function decrementQuantity(productId) {
        var quantityField = document.getElementById('quantity_' + productId);
        var currentQuantity = parseInt(quantityField.value);
        if (currentQuantity > 1) {
            var newQuantity = currentQuantity - 1;
            quantityField.value = newQuantity;

       
            updateQuantity(productId, newQuantity);
        }
    }

    function updatePageTotalPrice() {
        var total = 0;
        var subtotals = document.querySelectorAll('.subtotal');
        subtotals.forEach(function(subtotal) {
            total += parseFloat(subtotal.textContent);
        });

        var totalPriceField = document.getElementById('totalPrice');
        totalPriceField.textContent = total.toFixed(2); 
    }

    function updateTotalPrice(productId, newQuantity) {
        var pricePerItem = parseFloat(document.getElementById('price_' + productId).textContent);
        var subtotalField = document.getElementById('subtotal_' + productId);

        var newSubtotal = pricePerItem * newQuantity;
        subtotalField.textContent = newSubtotal.toFixed(2); 
    }
</script>

<script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>
</body>
</html>
