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




// Fetch slide images from the database
$sql = "SELECT * FROM slides";
$result = $conn->query($sql);

$slides = array();
if ($result->num_rows > 0) {
    // Fetching data from each row
    while ($row = $result->fetch_assoc()) {
        $slides[] = $row['img']; // 
    }
}


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

.carousel-inner img {

    height: 600px; 
    width:90%;
   padding:20px;
   border-radius:50px;
   margin-left:75px;
}
#carouselExampleIndicators{
    margin-top:50px;
}

h3{
    margin-top:50px;
    text-align:center;
    color:#4b16ad;
}
.row{
    margin-top:50px;
    display:flex;
    flex-wrap:wrap;
    align-items:center;
    justify-content:space-between;
    
}
.wrapper{
    overflow:hidden;
    border-radius:12px;
    border:5px solid #4b16ad;
   margin-top:5px;
  
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

   

</style>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?> 
    <!-- Image Slider -->
    <h3>welcome</h3>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php for ($i = 0; $i < count($slides); $i++): ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $i ?>" <?= ($i == 0) ? 'class="active"' : '' ?>></li>
            <?php endfor; ?>
        </ol>
        <div class="carousel-inner">
            <?php for ($i = 0; $i < count($slides); $i++): ?>
                <div class="carousel-item <?= ($i == 0) ? 'active' : '' ?>">
                    <img  src="<?= $slides[$i] ?>" alt="Slide <?= $i+1 ?>">
                </div>
            <?php endfor; ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Footer -->
    
        <?php 
        
        $sqlspecial = "SELECT * FROM special";
        $resultspecial = $conn->query($sqlspecial);
        $specials = array();
if ($resultspecial->num_rows > 0) {
    while ($row = $resultspecial->fetch_assoc()) {
        $specials[] = $row; 
    }
}
$conn->close();
        
        ?>
      <section class="category-section">
        <div class="container">
            <h3>Special</h3>
            <div class="row">
                <?php
                
                foreach ($specials as $special) {
                    
                    echo '<div class="col-md-4">';
                    echo '<div class="category">';
                    echo '<div class="wrapper">';
                    echo '<img src="' . $special['img'] . '" alt="' . $special['name'] . '" class="img-fluid">';
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>




    
    <script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>






    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
