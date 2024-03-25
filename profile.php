<?php  
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: loginpage.php");
    exit();
}

$user_id = $_SESSION["user_id"];

include("connection.php");

$sql = "SELECT * FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


if (!$result) {
    echo "Error executing query: " . $stmt->error;
    exit();
}

if ($result->num_rows == 0) {
    echo "No user found.";
    exit();
}


$row = $result->fetch_assoc();


if ($row !== null) {
    $username = $row['username'] ?? '';
    $email = $row['email'] ?? '';
    $mobile = $row['mobile'] ?? '';
} else {
    echo "Error: Unexpected null value for user data.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>User Profile</title>
</head>
<style>
    form {
        width: 500px;
        margin: auto;
        margin-top: 150px;
    }
</style>
<body>
    <?php include("navbar.php") ?>
    <form action="" method="post">
        <label for='username'>Username</label>
        <input type='text' name='username' class='form-control' id='username' value='<?php echo $username; ?>' readonly>
        <label for='email'>Email ID</label>
        <input type='email' name='email' class='form-control' id='email' value='<?php echo $email; ?>' readonly>
        <label for='mobile'>Phone</label>
        <input type='tel' name='mobile' class='form-control' id='mobile' value='<?php echo $mobile; ?>' readonly>
    </form>
</body>
</html>
