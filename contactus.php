<?php 
session_start();


if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {

    header("Location: loginpage.php");
    exit();
}

include("connection.php");
$success_message = "";
$emailerr =$phoneerr = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
      
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailerr = "Invalid email format";
    }


    if (!preg_match("/^\d{10}$/", $phone)) {
        $phoneerr = "Invalid phone number format";
    }

  
    if (empty($emailerr) && empty($phoneerr)) {

    $sql = "INSERT INTO message (email, phone, message) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sss", $email, $phone, $message);

    if ($stmt->execute()) {
        $success_message = "Message sent successfully!";
  
    } else {
        echo "Error";
    }
}
} elseif ($_SERVER["REQUEST_METHOD"]=="GET") {
   
} else {
    
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<style>

    .img-fluid{
        height:400px;
        width:500px;
        margin-left:300px;
    }
    footer{
        margin-top:50px;
    }
</style>
<body>
  
    <?php include 'navbar.php'; ?>


    <div class="container mt-5">
        <img src="contactus.jpg" class="img-fluid" alt="Contact Us Image">
    </div>

    
    <div class="container mt-5">
        <h2>Contact Us</h2>
        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
            <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);  ?>" method="post">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required><span class="text-danger"><?php echo $emailerr; ?></span>
            </div>
            <div class="form-group">
                <label for="phone">Phone number</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter phone number" required>    <span class="text-danger"><?php echo $phoneerr; ?></span>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

   



    <script>
        var loggedInUser = sessionStorage.getItem('loggedInUser'); 
        if (loggedInUser) {
            document.getElementById("loggedInUser").innerHTML = loggedInUser;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
