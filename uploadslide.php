<?php
include 'connection.php';

// Check if form is submitted
if(isset($_POST['submit'])) {
    $file = $_FILES['image'];

    // File properties
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Check file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg');

    if(in_array($fileExt, $allowedExtensions)) {
        // Check if file is uploaded without errors
        if($fileError === 0) {
            // Read file data
            $fileData = file_get_contents($fileTmpName);
            $fileData = mysqli_real_escape_string($conn, $fileData); // Prevent SQL injection

            // Insert file data into database
            $sql = "INSERT INTO slides (img) VALUES ('$fileName')";
            if ($conn->query($sql) === TRUE) {
                echo "File uploaded successfully.";
                header("Location: adminslide.php");
                exit(); 
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Only JPG and JPEG files are allowed.";
    }
}

// Close connection
$conn->close();
?>
