<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));

    if ($username && $password) {
        $hashed_password = md5($password); // Simple hashing (for demonstration)
        
        // Default role is set to 'customer'
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', 'customer')";
        
        if (mysqli_query($conn, $query)) {
            echo "Registration successful!";
            header('location: login.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles/logreg1.css">
     
    <style>
         body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    background-image: url('img/bg.jpg'); 
    background-size: cover;
    background-attachment: fixed;
    }
    </style>

</head>
<body>
<div class="form-box"> <!-- New form-box container -->
        <div class="container">
            <h2>Register</h2>
            <form method="POST" action="register.php">
                <div class="input-box"> <!-- New input-box container -->
                    <span><ion-icon name="person-add-sharp"></ion-icon></ion-icon></span>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-box"> <!-- New input-box container -->
                    <span><ion-icon name="lock-closed-sharp"></ion-icon></span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Register</button>    
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</body>
</html>
