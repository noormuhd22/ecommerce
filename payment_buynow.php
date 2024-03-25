<?php 

include('connection.php');
session_start();
date_default_timezone_set("Asia/Calcutta");

// Extracting payment details
$paymentid = $_POST['payment_id'];
$totalprice = $_POST['totalprice']; // Total price received from Razorpay

// Extracting delivery information
$name = $_POST['name'];
$address = $_POST['address'];
$state = $_POST['state'];
$city = $_POST['city'];
$pincode = $_POST['pincode'];
$mobile = $_POST['mobile'];
 $user_id = $_SESSION['user_id'];
 $productid = $_POST['productId'];

// Current date and time
$dt = date('Y-m-d h:i:s');

// Inserting payment and delivery information into the orders table
$sql = "INSERT INTO orders (payment_id, added_date, totalprice, name, address, state, city, pincode, mobile,user_id) 
        VALUES ('$paymentid', '$dt', '$totalprice', '$name', '$address', '$state', '$city', '$pincode', '$mobile','$user_id')";

$result = mysqli_query($conn, $sql);

if($result) {
    // Retrieve the order ID
    $order_id = mysqli_insert_id($conn);

   
    $cart_sql = "SELECT * FROM product WHERE id = '$productid'";
    $cart_result = mysqli_query($conn, $cart_sql);

    // Insert each product detail into the new database table
    while ($row = mysqli_fetch_assoc($cart_result)) {
        $product_id = $row['id'];
        $product_name = $row['name'];
        $price = $row['price'];
        $image =$row['image'];
        $quantity = 1;

        // Insert product details into the new table
        $insert_product_sql = "INSERT INTO orderdetails (orderid, productid, productname, price, quantity,user_id,image) 
                               VALUES ('$order_id', '$product_id', '$product_name', '$price', '$quantity','$user_id','$image')";
        mysqli_query($conn, $insert_product_sql);
    }

  

    // Store the order ID in session for further processing or display
    $_SESSION['paymentid']=$paymentid;
    $_SESSION['order_id'] = $order_id;

    echo 'done';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

?>
