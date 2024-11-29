<?php
session_start();
include 'db.php'; // Database connection

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $username = htmlspecialchars(trim($_POST['username']));
    $password = md5(htmlspecialchars(trim($_POST['password']))); // You should consider using password_hash() and password_verify()

    // Query to check if user exists with the given username and password
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);

        // Store the entire user record in the session
        $_SESSION['user'] = $user; // Store user data in the session
        $_SESSION['role'] = $user['role']; // Store role for role-based access

        // Optionally set a cookie for username (you can remove this if not necessary)
        setcookie("username", $user['username'], time() + (86400 * 30), "/");

        // Redirect to bookstore or any page after successful login
        header("Location: bookstore.php");
        exit();
    } else {
        // Error message for invalid credentials
        $error = "Invalid login credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <div class="form-box">
        <div class="container">
            <h2>Login</h2>
            <form method="POST" action="login.php">
                <div class="input-box">
                    <span><ion-icon name="person-sharp"></ion-icon></span>
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-box">
                    <span><ion-icon name="lock-closed-sharp"></ion-icon></span>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </form>
        </div>
    </div>

    <!-- Display error message if credentials are invalid -->
    <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
    <?php endif; ?>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
