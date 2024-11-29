<?php
session_start();
include 'db.php'; // Include your database connection

// Make sure the user is logged in
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo "Error: User session is not set properly.";
    exit();
}

// Ensure that the session cart is an array
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$user_id = $_SESSION['user']['id'];  // Make sure $_SESSION['user'] is an array and contains 'id'

// Fetch cart items from the database, including the image URL
$query = "
    SELECT cart.id AS cart_id, books.title, books.price, books.image, cart.quantity 
    FROM cart 
    JOIN books ON cart.book_id = books.id 
    WHERE cart.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query execution was successful
if (!$result) {
    echo "Error fetching cart items.";
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="styles/cart.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    /* Styling for the Proceed to Checkout button */
    .btn-proceed-checkout {
        display: inline-block;
        background-color: #28a745; /* Green background */
        color: white;
        font-size: 16px;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-proceed-checkout:hover {
        background-color: #218838; /* Darker green on hover */
    }

    .btn-proceed-checkout:active {
        background-color: #1e7e34; /* Even darker green when clicked */
    }
</style>
</head>
<body>

<!-- Navigation Bar -->
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

<!-- Page Content -->
<h1>Your Cart</h1>

<?php if ($result->num_rows > 0) { ?>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { 
                $item_total = $row['price'] * $row['quantity'];
                $total += $item_total;
            ?>
            <tr id="cart-item-<?php echo $row['cart_id']; ?>">
                <td>
                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="book-img">
                </td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>₱<?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <input type="number" value="<?php echo $row['quantity']; ?>" min="1" class="quantity-input" id="quantity-<?php echo $row['cart_id']; ?>" data-cart-id="<?php echo $row['cart_id']; ?>">
                </td>
                <td>₱<?php echo number_format($item_total, 2); ?></td>
                <td>
                    <button class="btn btn-danger" onclick="removeFromCart(<?php echo $row['cart_id']; ?>)">Remove</button>
                    <button class="btn btn-primary" onclick="updateQuantity(<?php echo $row['cart_id']; ?>)">Update</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <h3>Total: ₱<?php echo number_format($total, 2); ?></h3>
    <a href="checkout.php" class="btn btn-success" style="display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-align: center; text-decoration: none; border-radius: 5px; font-size: 16px; transition: background-color 0.3s ease;">Proceed to Checkout</a>

<?php } else { ?>
    <p>Your cart is empty.</p>
<?php } ?>
<!-- JavaScript to handle AJAX for Remove and Update -->
<script>
    function removeFromCart(cartId) {
        const formData = new FormData();
        formData.append('cart_id', cartId);
        
        fetch('remove_from_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cart-item-' + cartId).remove();
                alert('Item removed successfully!');
                location.reload(); // Reload page to reflect cart changes
            } else {
                alert(data.message || 'An error occurred while removing the item.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function updateQuantity(cartId) {
        const quantity = document.getElementById('quantity-' + cartId).value;
        
        if (quantity < 1) {
            alert('Quantity must be at least 1');
            return;
        }

        const formData = new FormData();
        formData.append('cart_id', cartId);
        formData.append('quantity', quantity);

        fetch('update_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Quantity updated successfully!');
                location.reload(); // Reload page to reflect cart changes
            } else {
                alert(data.message || 'An error occurred while updating the cart.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>
