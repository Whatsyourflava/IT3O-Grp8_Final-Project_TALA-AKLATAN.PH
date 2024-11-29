<?php
session_start();
include 'db.php'; // Include your database connection

// Make sure the user is logged in
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo "Error: User session is not set properly.";
    exit();
}

// Get the user_id from session
$user_id = $_SESSION['user']['id'];

// Fetch cart items from the database
$query = "
    SELECT cart.id AS cart_id, books.title, books.price, cart.quantity, books.image
    FROM cart
    JOIN books ON cart.book_id = books.id
    WHERE cart.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any items in the cart
if ($result->num_rows <= 0) {
    echo "Error: Your cart is empty. Please add items to your cart before proceeding.";
    exit();
}

// Initialize variables
$cart_items = [];
$cart_total = 0;

// Fetch the cart items
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    // Calculate the total for each item (quantity * price)
    $cart_total += $row['price'] * $row['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
       /* General Form Styles */
.checkout-form {
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.checkout-form h2 {
    text-align: center;
    color: #333;
    font-size: 1.8em;
    margin-bottom: 20px;
}

.checkout-form label {
    display: block;
    margin-bottom: 5px;
    font-size: 1em;
    color: #555;
}

.checkout-form input, 
.checkout-form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1em;
    color: #333;
}

.checkout-form input[type="text"]:focus,
.checkout-form input[type="date"]:focus,
.checkout-form select:focus {
    border-color: #007bff;
    outline: none;
}

.checkout-form input::placeholder {
    color: #888;
}

.checkout-form button {
    width: 100%;
    padding: 12px;
    background-color: #8b4513;
    color: white;
    font-size: 1.1em;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.checkout-form button:hover {
    background-color: #0056b3;
}

.checkout-form .form-group {
    margin-bottom: 20px;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .checkout-form {
        padding: 15px;
    }
}

    </style>
</head>
<body>

<!-- Navigation Bar (same as cart.php) -->
<nav>
    <ul class="navbar">
        <li class="logo-item">
            <a href="bookstore.php">
                <img src="img/logo.jpeg" alt="Tala Aklatan Logo" class="logo">
            </a>
        </li>

        <?php if (isset($_SESSION['user'])) { ?>
            <li><a href="logout.php">Logout</a></li>
            <?php if ($_SESSION['user']['role'] === 'admin') { ?>
                <li><a href="admin.php">Admin Dashboard</a></li>
            <?php } ?>
            <li class="cart-item">
                <a href="cart.php" class="cart-link">
                    <i class="bi bi-cart-fill"></i>
                    <?php if (isset($cart_items) && count($cart_items) > 0) { ?>
                        <span class="badge"><?php echo count($cart_items); ?></span>
                    <?php } ?>
                </a>
            </li>
        <?php } else { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php } ?>
    </ul>
</nav>

<!-- Page Content for Checkout -->
<div class="checkout-container">
    <h1>Checkout</h1>

    <!-- Cart Summary -->
    <div class="checkout-summary">
        <h2>Cart Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item) { 
                    $item_total = $item['price'] * $item['quantity'];
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="book-img" width="50"></td>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td>₱<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₱<?php echo number_format($item_total, 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3>Total: ₱<?php echo number_format($cart_total, 2); ?></h3>
    </div>

    <!-- Checkout Form -->
    <!-- Checkout Form -->
<form action="process_checkout.php" method="POST" class="checkout-form">
    <h2>Shipping Information</h2>
    
    <label for="address">Address:</label>
    <input type="text" name="address" id="address" placeholder="Enter your address" required>

    <label for="contact">Contact Number:</label>
    <input type="text" name="contact" id="contact" placeholder="Enter your contact number" required>

    <label for="shipping_method">Shipping Method:</label>
    <select name="shipping_method" id="shipping_method" required>
        <option value="standard">Standard Shipping</option>
        <option value="express">Express Shipping</option>
        <option value="overnight">Overnight Shipping</option>
    </select>

    <label for="shipping_date">Preferred Shipping Date:</label>
    <input type="date" name="shipping_date" id="shipping_date" required>

    <label for="payment_method">Payment Method:</label>
    <select name="payment_method" id="payment_method" required>
        <option value="credit_card">Credit Card</option>
        <option value="paypal">PayPal</option>
        <option value="cod">Cash on Delivery</option>
    </select>

    <button type="submit" class="btn-checkout">Place Order</button>
</form>

</div>

</body>
</html>
