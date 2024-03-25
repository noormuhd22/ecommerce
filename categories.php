<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: loginsports.php");
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

// Fetch categories from the database
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

$categories = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row; // Store each category row in the $categories array
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
.row{
    margin-top:70px;
    
}
.wrapper{
    overflow:hidden;
    border-radius:12px;
}
   .wrapper img{
        height:300px;
        border-radius:12px;
        width:100%;
        transition:scale 400ms;
    }
    .wrapper:hover img{
        scale:120%;
        
    }
    .redirect{
        color:black;
        text-decoration:none;
    }
    .redirect:hover{
        text-decoration:none; 
    }
</style>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?> 

    <!-- Image Slider -->
    <!-- Your image slider code goes here -->

    <!-- Category Section -->
    <section class="category-section">
        <div class="container">
            <div class="row">
                <?php
                // Loop through the categories fetched from the database
                foreach ($categories as $category) {
                    // Output the category name and image
                    echo '<div class="col-md-4">';
                    echo '<div class="category">';
                    
                    if ($category['categoryname'] == 'Boot') {
                        
                        echo '<a href="boots.php" class="redirect">';
                        echo '<h2>' . $category['categoryname'] . '</h2>';
                        echo '<div class="wrapper">';
                        echo '<img src="' . $category['image'] . '" alt="' . $category['categoryname'] . '" class="img-fluid">';
                        echo '</div>';
                        echo '</a>';
                    } else if($category['categoryname'] == 'Jersey') {
                            // Wrap category name and image in anchor tag with href pointing to "boots.php"
                            echo '<a href="Jersey.php" class="redirect">';
                            echo '<h2>' . $category['categoryname'] . '</h2>';
                            echo '<div class="wrapper">';
                            echo '<img src="' . $category['image'] . '" alt="' . $category['categoryname'] . '" class="img-fluid">';
                            echo '</div>';
                            echo '</a>';
                        
                    }
                     else if($category['categoryname'] == 'NBA jersey') {
                        // Wrap category name and image in anchor tag with href pointing to "boots.php"
                        echo '<a href="nbajersey.php" class="redirect">';
                        echo '<h2>' . $category['categoryname'] . '</h2>';
                        echo '<div class="wrapper">';
                        echo '<img src="' . $category['image'] . '" alt="' . $category['categoryname'] . '" class="img-fluid">';
                        echo '</div>';
                        echo '</a>';
                    
                    }
                    else if($category['categoryname'] =='Cap') {
                        // Wrap category name and image in anchor tag with href pointing to "boots.php"
                        echo '<a href="cap.php" class="redirect">';
                        echo '<h2>' . $category['categoryname'] . '</h2>';
                        echo '<div class="wrapper">';
                        echo '<img src="' . $category['image'] . '" alt="' . $category['categoryname'] . '" class="img-fluid">';
                        echo '</div>';
                        echo '</a>';
                    
                    }  else {
                        // Output category name and image without anchor tag
                        echo '<h2>' . $category['categoryname'] . '</h2>';
                        echo '<div class="wrapper">';
                        echo '<img src="' . $category['image'] . '" alt="' . $category['categoryname'] . '" class="img-fluid">';
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                ?>
                
            </div>
        </div>
    </section>
    
    <!-- Footer -->
  
    
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
