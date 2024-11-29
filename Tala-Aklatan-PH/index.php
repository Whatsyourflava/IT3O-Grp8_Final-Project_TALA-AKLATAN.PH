<?php
session_start();
include 'db.php';

// Fetch all books from the database
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

// Store books in an array
$books = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
} else {
    echo "No books found";
}

// Shuffle the books array to display them randomly
shuffle($books);

// Display a set of books (for example, 6 books)
$books_to_display = array_slice($books, 0, 6);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tala AklatanPH - Online Bookstore</title>
    <link rel="stylesheet" href="styles/index.css">
     <!-- Add Bootstrap CDN -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome CDN for social media icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
          body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-image: url('img/logreg.avif');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #ffffff;
            overflow-x: hidden;
        }
        html{
            height: 100%;
        }
        .books {
            margin-top: 30px;
        }

        .book-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Creates a 3x3 grid */
            gap: 20px;
        }

        .book-item {
            text-align: center;
        }

        .books h2 {
            font-size: 28px;
            color: #f5deb3;
            text-align: center;
            margin: 15px 0;
            text-transform: uppercase;
            border-bottom: 2px solid #d2a679;
            padding-bottom: 5px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); 
        }

        .book-image {
            width: 100%;
            max-width: 200px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding-top: 400px;
            margin-bottom: 300px;
        }

        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            width: 100%;
            position: relative;
            margin-top: auto;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .footer-links a img {
            width: 30px;
            margin-right: 0px;
        }

        .footer-links a {
            display: inline-block;
        }

        .footer-extra-links ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        .footer-extra-links li a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .footer-extra-links li a:hover {
            color: #ff8c00;
        }

        .footer-bottom {
            text-align: center;
            font-size: 14px;
            padding-top: 10px;
            border-top: 1px solid #444;
        }

        .container button {
            padding: 12px 25px;
            background-color: #ff8c00;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .container button:hover {
            background-color: #e07b00;
            transform: translateY(-2px);
        }

        .container button:focus {
            outline: none;
        }
        .footer-links {
        text-align: center; /* Center-align the container */
        margin-bottom: 15px; /* Add spacing below */
        }

        .footer-links a {
        display: inline-block; /* Ensure proper spacing for inline elements */
        margin: 0 10px; /* Add horizontal spacing between icons */
        font-size: 24px; /* Make icons larger */
        color: #fff; /* Set icon color to white */
        transition: color 0.3s ease; /* Add a hover transition */
    }

    .footer-links a:hover {
    color: #ff8c00; /* Change color on hover */
    }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav>
    <ul class="navbar">
        <li><img src="img/logo.jpeg" alt="Online Bookstore Logo" class="logo"></li>
        <?php if (isset($_SESSION['user'])) { ?>
            <li><a href="logout.php">Logout</a></li>
            <?php if ($_SESSION['role'] === 'admin') { ?>
                <li><a href="admin.php">Admin Dashboard</a></li>
            <?php } ?>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>
    </ul>
</nav>

<!-- Modal for Welcome Message -->
<div id="welcomeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>
            Welcome, <?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Reader'); ?>!
        </h1>
        <p>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin') { ?>
                Hello Admin! Manage the bookstore and oversee the collections.
            <?php } elseif (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'customer') { ?>
                Explore our collections and discover your next favorite book!
            <?php } else { ?>
                Join our community of readers and find the perfect book for you.
            <?php } ?>
        </p>
        <a href="bookstore.php" class="button" style="margin-top: 20px;">Browse Books</a>
    </div>
</div>

<div class="container">
    <div class="form-box">
        <form action="bookstore.php" method="GET">
            <h1>Welcome to Tala Aklatan</h1>
            <p>Illuminating minds, one book at a time, Shining bright with every page.</p>
            <button type="submit">Browse Books</button>
        </form>
    </div>

    <!-- Display Books -->
    <div class="books">
        <h2>Featured Books</h2>
        <div class="book-list">
            <?php foreach ($books_to_display as $book) { ?>
                <div class="book-item">
                    <img src="<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>" class="book-image">
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    var modal = document.getElementById("welcomeModal");
    var span = document.getElementsByClassName("close")[0];

    window.onload = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>

<!-- Footer Section -->
<footer>
    <div class="footer-content">
        <div class="footer-links">
            <a href="https://www.facebook.com/patrick.collado.12" target="_blank">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://x.com/patrickcollado9" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.instagram.com/pat_collado00/" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://linkedin.com" target="_blank">
                <i class="fab fa-linkedin"></i>
            </a>
        </div>
        <!-- Additional Links -->
        <div class="footer-extra-links">
            <ul>
                <li><a href="help/privacy.php">Privacy Policy</a></li>
                <li><a href="help/terms.php">Terms & Conditions</a></li>
                <li><a href="help/contact.php">Contact Us</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p style="color: white;">&copy; 2024 Tala Aklatan. All rights reserved.</p>
    </div>
</footer>

</html>

<?php
// Close the database connection
$conn->close();
?>
