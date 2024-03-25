<?php
session_start();


$err = "";
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: adminlogin.php");
    exit();
}


if(isset($_GET['id'])) {
    $slide_id = $_GET['id'];
} else {
    
    header("Location: adminlogin.php");
    exit();
}

include 'connection.php';

$sql = "SELECT * FROM slides WHERE id = $slide_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $slide = $result->fetch_assoc();
} else {
   
    header("Location: adminslide.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = $_FILES['image']['name'];
        
     
        $file_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        
        
        $allowed_extensions = array("jpg", "jpeg","jfif");

        if(in_array($file_extension, $allowed_extensions)) {
            
            $upload_path = "uploads/"; 
            move_uploaded_file($image_tmp, $upload_path . $image_name);

            $image_path = $upload_path . $image_name;
            $sql_update_image = "UPDATE slides SET img = '$image_path' WHERE id = $slide_id";
            if ($conn->query($sql_update_image) !== TRUE) {
                echo "Error updating image: " . $conn->error;
            } else {
                header("Location: adminslide.php");
                exit();
            }
        } else {
            $err =  "Invalid file format. Please upload files with .jpg,.jfif or .jpeg extension only.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slide</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .err{
        color:red;
    }
</style>
<body>

<?php include 'adminnavbar.php'; ?>


<div class="container mt-5">
    <h2>Edit Slide</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Update Slide</button><div class="err"><?php echo $err ?></div>
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
