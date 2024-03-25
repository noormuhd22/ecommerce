<?php

include("connection.php");

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $mobile = mysqli_real_escape_string($conn, $_POST["mobile"]);

    // Form validation
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $error_message = "Only letters and white space allowed in username.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {
        $error_message = "Invalid mobile number format.";
    } else {
  
        $check_query = "SELECT * FROM user WHERE username=?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error_message = "Username already exists. Please choose a different one.";
        } else {

            $insert_query = "INSERT INTO user (username, password, email, mobile) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssss", $name, $password, $email, $mobile);

            if ($stmt->execute()) {
                $success_message = "Account created successfully. You can now login.";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .container {
        width: 500px;
        margin-top: 200px;
        background-color: #4b16ad;
        padding: 20px;
        border: 1px solid #4b16ad;
        border-radius: 12px;
        color: white;
    }
</style>
<body>

<?php if (!empty($error_message)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
<?php } ?>

<?php if (!empty($success_message)) { ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
    </div>
<?php } ?>
<div class="container">

    <h3>Sign Up</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter username" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter password" required>
        </div>


        <div class="form-group">
            <label for="email">Email ID</label>
            <input type="email" class="form-control" name="email" placeholder="Enter email id" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile No</label>
            <input type="tel" class="form-control" name="mobile" placeholder="Enter Mobile Number" required>
        </div>

        <button type="submit" class="btn btn-primary">Sign Up</button>
        <br>
        <a href="loginpage.php">Back to Login</a>

    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
