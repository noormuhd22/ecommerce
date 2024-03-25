<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    exit();
}

// Check if category ID is provided in the URL
if(!isset($_GET['id'])) {
    // Redirect if ID is not provided
    header("Location: admincategories.php");
    exit();
}

// Include database connection
include 'connection.php';

// Fetch category details from the database
$catid = $_GET['id'];
$sql = "SELECT * FROM categories WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $catid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $category = $result->fetch_assoc();
} else {
    // Redirect if category not found
    header("Location: admincategories.php");
    exit();
}

$nameErr = $imageErr = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $name = $_POST['name'];
    if (!preg_match("/^[a-zA-Z0-9 ]*$/", $name)) {
        $nameErr = "Name can only contain letters, numbers, and spaces.";
    } else {
    
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $image_tmp = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $imageFileType = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

            // Check if file is a JPEG or JPG
            if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "jfif") {
                $imageErr = "Only JFIF,JPG and JPEG files are allowed.";
             

            } else {
                // Move uploaded file to desired location
                $upload_path = "uploads/"; // Change this to your desired directory
                move_uploaded_file($image_tmp, $upload_path . $image_name);

                // Update image path in the database
                $image_path = $upload_path . $image_name;
                $sql_update_image = "UPDATE categories SET image = ? WHERE id = ?";
                $stmt_update_image = $conn->prepare($sql_update_image);
                $stmt_update_image->bind_param("si", $image_path, $catid);
                if ($stmt_update_image->execute() !== TRUE) {
                    echo "Error updating image: " . $conn->error;
                }
            }
        }

        // Update name in the database
        $sql_update_name = "UPDATE categories SET categoryname = ? WHERE id = ?";
        $stmt_update_name = $conn->prepare($sql_update_name);
        $stmt_update_name->bind_param("si", $name, $catid);
        if ($stmt_update_name->execute() !== TRUE) {
            echo "Error updating category name: " . $conn->error;
        } else {
            
            header("Location: admincategories.php");
            exit();
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
<body>

<?php include 'adminnavbar.php'; ?>

<div class="container mt-5">
    <h2>Edit Category</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['categoryname']); ?>">
            <?php if(isset($nameErr)) { echo "<span class='text-danger'>$nameErr</span>"; } ?>
        </div>
        <div class="form-group">
            <img src="<?php echo htmlspecialchars($category['image']); ?>" alt="img" style="max-width: 200px;">
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            <?php if(isset($imageErr)) { echo "<span class='text-danger'>$imageErr</span>"; } ?>
        </div>
        <button type="submit" class="btn btn-primary">Update Slide</button>
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
