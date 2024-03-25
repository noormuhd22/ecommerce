<?php
include 'connection.php';

// Check if form is submitted
if(isset($_POST['submit'])) {
    $file = $_FILES['image'];
    $cname = $_POST['categoryname'];
    $price = $_POST[ 'price'];
    $category = $_POST['category'];
    // File properties
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Check if file is uploaded without errors
    if($fileError === 0) {
        // Read file data
        $fileData = file_get_contents($fileTmpName);
        $fileData = mysqli_real_escape_string($conn, $fileData); // Prevent SQL injection

        // Insert file data into database
        $sql = "INSERT INTO product (image,name,price,category) VALUES ('$fileName','$cname','$price','$category')";
        if ($conn->query($sql) === TRUE) {
            echo "File uploaded successfully.";
            header("Location: adminproducts.php");
            exit(); 
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

// Close connection
$conn->close();
?>
