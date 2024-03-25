<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: adminlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $categoryname = $_POST["categoryname"];
    $price = $_POST["price"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $tempName = $_FILES["image"]["tmp_name"];
        $imageName = $_FILES["image"]["name"];


        $extension = pathinfo($imageName, PATHINFO_EXTENSION);

        if ($extension == "jpg" || $extension == "jpeg"||$extension =="jfif") {
       
            $uploadPath = "uploads/" . $imageName;
            move_uploaded_file($tempName, $uploadPath);

            include 'connection.php';
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            
            $sql = "INSERT INTO special (name, price, img) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $categoryname, $price, $uploadPath); 
            $stmt->execute();

            $stmt->close();
            $conn->close();

          header("location:adminsubcategories.php");
        } else {
            echo "Only JPG or JPEG files are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
} else {
    echo "Invalid request.";
}
?>
