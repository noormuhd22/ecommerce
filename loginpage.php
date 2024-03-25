<?php 

include("connection.php");

session_start();
$inco="";







if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);


    $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $name;
        $_SESSION['user_id'] = $row['user_id']; // Use the user ID from the database
        echo "<script>sessionStorage.setItem('loggedInUser', '$name');</script>";
        echo "<script>window.location.href='home.php';</script>";
        exit();
    } else {
        $inco = "Username and password are incorrect";
    }
    
}
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .container{
        width: 500px;
        margin-top: 200px;
        background-color:  #4b16ad;
    padding: 20px;
    border:1px solid #4b16ad;
    border-radius: 12px;
    color:white;
    
    }
    .err{
        color: red;
      
    }
</style>
<body>

<div class="container">
    <h3>Login</h3>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
        <span class="err"><?php echo $inco ?></span> <br>
        <a href="signup.php">Create Account</a>

    </form>

</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
