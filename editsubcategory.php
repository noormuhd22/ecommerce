<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: adminlogin.php");
    exit();
}


if(isset($_GET['id'])) {
    $productid = $_GET['id'];
} else {
    header("Location: adminsubcategories.php");
    exit();
}


include 'connection.php';


$sql = "SELECT * FROM special WHERE id = '$productid' ";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $product = $result->fetch_assoc();
} else {
   
    header("Location: adminproducts.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];

       
        $upload_path = "uploads/";
        move_uploaded_file($image_tmp, $upload_path . $image_name);

      
        $image_path = $upload_path . $image_name;
        $sql_update_image = "UPDATE special SET img = '$image_path' WHERE id = $productid";
        if ($conn->query($sql_update_image) !== TRUE) {
            echo "Error updating image: " . $conn->error;
        }
    }
    $name = $_POST['name'];
    $price = $_POST['price'];
    $sql_update_details = "UPDATE special SET name = '$name', price = '$price' WHERE id = $productid";
    if ($conn->query($sql_update_details) !== TRUE) {
        echo "Error updating product details: " . $conn->error;
    } else {
        header("Location: adminsubcategories.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'adminnavbar.php'; ?>

<div class="container mt-5">
    <h2>Edit Product</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
        </div>
        <div class="form-group">
            <label for="current_image">Current Image:</label><br>
            <img src="<?php echo $product['img']; ?>" alt="Current Image" style="max-width: 200px;">
        </div>
        <div class="form-group">
            <label for="image">New Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>

<script>
    var loggedInUser = sessionStorage.getItem('loggedInUser'); 
    if (loggedInUser) {
        document.getElementById("loggedInUser").innerHTML = loggedInUser;
    }
</script>
</body>
</html>
