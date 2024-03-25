
<?php
// Include the PHP file to establish database connection
include 'connection.php';

// Check if the ID parameter is set
if(isset($_GET['id'])) {
    // Sanitize the ID parameter to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // SQL query to delete the image from the database
    $sql = "DELETE FROM special WHERE id = $id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the page where the table is displayed after successful deletion
        header("Location: adminsubcategories.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If ID parameter is not set, redirect back to the page where the table is displayed
    header("Location: adminsubcategories.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>
