<?php
session_start();



if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: loginpage.php");
    exit();
}

// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "ecommerce"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_keyword = "";
if(isset($_GET['Search_keyword']) && $_GET['Search_keyword'] != ''){
    $search_keyword = $_GET['Search_keyword'];
}
$sql = "SELECT * FROM product WHERE 
        name LIKE '%$search_keyword%' OR
        category LIKE '%$search_keyword%' OR
        price LIKE '%$search_keyword%'";

$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row; // Store each product row in the $products array
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    img {
    
        border-radius: 12px;
       height:300px;
    }
    .product-section{
        margin-top:50px;
    }
  .ss   form {
   float:right;
    padding: 20px;
 
    border-radius: 5px;
    
}

.ss label {
    font-weight: bold;
}


.ss input[type="text"] {
    width: 200px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
}


.ss button[type="submit"] {
    padding: 8px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}


.ss button[type="submit"]:hover {
    background-color: #0056b3;
}

#size{
    font-size:15px;
}
</style>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>


    <div class="ss">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <label for="Search_keyword">search:</label>
        <input type="text" placeholder="search" id="Search_keyword" name="Search_keyword">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>
    <section class="product-section">
    <div class="container">
        <div class="row">
            <?php
            // Loop through the products fetched from the database
            foreach ($products as $product) {
                // Output the product details
                echo '<div class="col-lg-4 col-md-6 mb-4">';
                echo '<div class="card">';
                echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '" class="card-img-top">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $product['name'] . '</h5>';
                echo '<p class="card-text"><span class="material-symbols-outlined" id="size">
                currency_rupee
                </span>' . $product['price'] . '</p>';
                echo '<div class="btn-group">';
                echo '<form action="buynow.php" method="post">';
                echo '<input type="hidden" name="productId" value="' . $product['id'] . '">';
                echo '<input type="hidden" name="userId" value="' . $_SESSION['user_id'] . '">';
                echo '<input type="hidden" name="name" value="' . $product['name'] . '">';
                echo '<input type="hidden" name="price" value="' . $product['price'] . '">';
                echo '<input type="hidden" name="image" value="' . $product['image'] . '">';
                echo '<button type="submit" class="btn btn-success">BuyNow</button>';
                echo '</form>';     
                echo '<form action="cart.php" method="post">';
                echo '<input type="hidden" name="productId" value="' . $product['id'] . '">';
                echo '<input type="hidden" name="userId" value="' . $_SESSION['user_id'] . '">';
                echo '<input type="hidden" name="name" value="' . $product['name'] . '">';
                echo '<input type="hidden" name="price" value="' . $product['price'] . '">';
                echo '<input type="hidden" name="image" value="' . $product['image'] . '">';
                echo '<button type="submit" class="btn btn-primary">Add to Cart</button>';
                echo '</form>';     
                     echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>


    
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

        function buyNow(productId) {
            window.location.href = 'buynow.php?id=' + productId;
        }
    </script>



</body>
</html>
 