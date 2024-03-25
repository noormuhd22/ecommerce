<?php


session_start();


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: adminsports.php");
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



$sql = "SELECT COUNT(*) AS total_orders FROM orders"; 
$result = $conn->query($sql);
$total_orders = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_orders = $row['total_orders'];
}



$sql = "SELECT COUNT(*) AS total_users FROM user";
$result = $conn->query($sql);
$total_users = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_users= $row['total_users'];
}



$sql = "SELECT COUNT(*) AS total_cat FROM categories";
$result = $conn->query($sql);
$total_cat= 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_cat= $row['total_cat'];
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
.welcome-box {
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  max-width: 400px; /* Adjust the max-width as needed */
 margin-top:20px;
 margin-left:10px;
}

/* Optional: Adjust the styles for the h3 tag */
.welcome-box h3 {
  margin: 0;
  font-size: 1.5em;
}
section{
    display:flex;
    width:100%;
}
 a h4:hover{
    text-decoration:none;
}

</style>
<body>

<?php include 'adminnavbar.php'; ?> 


<div class="welcome-box">
  <h3>Welcome Back Admin</h3>
</div>
<section>
<div class="welcome-box">
<p>Total Orders </p>
<h2><?php echo $total_orders; ?></h2>
<a href="adminorders.php"><h4>view</h4></a>
</div>

<div class="welcome-box">
<p>Total Reg Users </p>
<h2><?php echo $total_users; ?></h2>
<a href="adminusers.php"><h4>view</h4></a>
</div>

<div class="welcome-box">
<p>Total Categories </p>
<h2><?php echo $total_cat; ?></h2>
<a href="admincategories.php"><h4>view</h4></a>
</div>
</section>
 
    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
