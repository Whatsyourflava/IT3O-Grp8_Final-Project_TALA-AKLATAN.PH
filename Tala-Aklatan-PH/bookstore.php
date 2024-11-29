<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>
    <link rel="stylesheet" href="styles/bookstore1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="scripts/cart.js" defer></script>
</head>

<style>
footer {
    background-color: #8b4513; /* Dark brown background */
    color: #ffffff; /* White text */
    padding: 5px 0; /* Reduced padding to shrink the footer */
    margin-top: 20px; /* Reduced space between content and footer */
    width: 100%; /* Ensure the footer spans the full width */
}

.footer-content {
    display: flex;
    flex-direction: column; /* Stack the content */
    align-items: center; /* Center the content */
    justify-content: center;
    max-width: 1200px; /* Same width as the navbar */
    margin: 0 auto;
    padding: 0 20px;
}

.footer-links {
    display: flex;
    gap: 10px; /* Reduced gap between social icons */
    margin-bottom: 10px; /* Reduced space between social icons and additional links */
}

.footer-links a {
    color: #ffffff; /* White text for links */
    font-size: 20px; /* Larger icon size */
    text-decoration: none;
    transition: color 0.3s;
}

.footer-links a:hover {
    color: #ffd700; /* Gold color on hover */
}

.footer-extra-links ul {
    list-style: none;
    padding: 0;
    display: flex;
    gap: 10px; /* Reduced gap between extra links */
    margin-top: 5px; /* Reduced margin to compress the layout */
}

.footer-extra-links ul li {
    font-size: 16px; /* Keeping the same font size */
}

.footer-extra-links ul li a {
    color: #ffffff; /* White text for extra links */
    text-decoration: none;
    transition: color 0.3s;
}

.footer-extra-links ul li a:hover {
    color: #ffd700; /* Gold on hover */
}

.footer-bottom {
    text-align: center;
    font-size: 14px; /* Keeping the same font size for copyright */
    color: #ccc; /* Light gray text for copyright */
    margin-top: 5px; /* Reduced margin for footer bottom */
}

/* Social Media Icons */
footer .footer-links i {
    font-size: 20px; /* Icon size matching navbar items */
    transition: color 0.3s;
}

footer .footer-links i:hover {
    color: #ffd700; /* Gold color for icons on hover */
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-content {
        text-align: center;
    }

    .footer-links {
        margin-bottom: 10px; /* Less space between icons */
    }

    .footer-extra-links ul li {
        margin-bottom: 6px; /* Reduced margin between extra links */
    }
}
</style>
<body>

<nav>
    <ul class="navbar">
        <!-- Logo as a clickable link to home -->
        <li><a href="index.php"><img src="img/logo.jpeg" alt="Tala Aklatan Logo" class="logo"></a></li>
        
        <?php if (isset($_SESSION['user'])) { ?>
            <li><a href="logout.php">Logout</a></li>
            <?php if ($_SESSION['role'] === 'admin') { ?>
                <li><a href="admin.php">Admin Dashboard</a></li>
            <?php } ?>

            <!-- Cart Icon -->
            <li>
                <a href="cart.php" class="cart-link">
                    <i class="bi bi-cart-fill"></i>
                    <!-- Display Cart Count if items exist -->
                    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
                        <span class="badge"><?php echo count($_SESSION['cart']); ?></span>
                    <?php } ?>
                </a>
            </li>

        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>
    </ul>
</nav>


<div class="container">
    <h1>Available Books</h1>
    <div class="book-list">
        <?php
        // Fetch books from the database
        $result = mysqli_query($conn, "SELECT * FROM books");
        if (mysqli_num_rows($result) > 0) {
            while ($book = mysqli_fetch_assoc($result)) {
                ?>
                <div class='book'>
                    <img src='<?php echo htmlspecialchars($book['image']); ?>' alt='<?php echo htmlspecialchars($book['title']); ?>' class='book-image'>
                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                    <p>Description: <?php echo htmlspecialchars($book['description']); ?></p>
                    <p>Price: ₱<?php echo number_format($book['price'], 2); ?></p>
                    <form method="POST" action="add_to_cart.php">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <label for="quantity_<?php echo $book['id']; ?>">Quantity:</label>
                        <input type="number" id="quantity_<?php echo $book['id']; ?>" name="quantity" value="1" min="1" style="width: 50px;">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p>No books available at the moment. Please check back later!</p>";
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <!-- Social Media Links -->
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

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p style="color: white;">&copy; 2024 Tala Aklatan. All rights reserved.</p>
    </div>
</footer>

</html>