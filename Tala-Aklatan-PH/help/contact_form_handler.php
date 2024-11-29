<?php
session_start();
include 'db.php';  


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get the form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $submitted_at = date("Y-m-d H:i:s");  

   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: contact.php");
        exit();
    }

    // SQL Insert Query
    $sql = "INSERT INTO contact_messages (name, email, message, submitted_at) 
            VALUES ('$name', '$email', '$message', '$submitted_at')";

    // Check if the query was successful
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Your message has been sent successfully!";
        header("Location: contact.php"); 
        exit();
    } else {
       
        $_SESSION['error'] = "Error: " . $conn->error;  
        header("Location: contact.php");
        exit();
    }
} else {
  
    header("Location: contact.php");
    exit();
}
?>
