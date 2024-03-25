<?php

include("connection.php"); 


if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    $sql = "INSERT INTO message (email, phone, message) VALUES (?, ?, ?)";
    
    
    $stmt = $conn->prepare($sql);


    $stmt->bind_param("sss", $email, $phone, $message);


    if ($stmt->execute()) {
    
        header("Location: contactus.php?status=success");
        exit();
    } else {

        header("Location: contactus.php?status=error");
        exit();
    }
} else {
 
    header("Location: contactus.php");
    exit();
}

?>
