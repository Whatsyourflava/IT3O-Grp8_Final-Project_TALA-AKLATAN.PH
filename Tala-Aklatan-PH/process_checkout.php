<?php
session_start();
include 'db.php'; // Include your database connection

// Make sure the user is logged in
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo "Error: User session is not set properly.";
    exit();
}

// Get user_id and the form data
$user_id = $_SESSION['user']['id'];
$address = $_POST['address'];
$contact = $_POST['contact'];
$shipping_method = $_POST['shipping_method'];
$shipping_date = $_POST['shipping_date'];
$payment_method = $_POST['payment_method'];

// Get the cart items
$query = "
    SELECT cart.id AS cart_id, cart.book_id, cart.quantity, books.title, books.price 
    FROM cart
    JOIN books ON cart.book_id = books.id
    WHERE cart.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the cart is empty
if ($result->num_rows <= 0) {
    echo "Error: Your cart is empty.";
    exit();
}

// Insert order into the database (inserting into `orders` table)
$query_order = "INSERT INTO orders (user_id, address, contact, shipping_method, shipping_date, payment_method, total_price, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_order = $conn->prepare($query_order);

// Calculate the total price of the order
$order_total = 0;
$cart_items = []; // Array to store cart items
while ($row = $result->fetch_assoc()) {
    $order_total += $row['price'] * $row['quantity'];
    $cart_items[] = $row; // Store cart items in an array
}

// Insert the order
$status = 'Pending';  // Initial status of the order
$stmt_order->bind_param('isssssss', $user_id, $address, $contact, $shipping_method, $shipping_date, $payment_method, $order_total, $status);
$stmt_order->execute();
$order_id = $stmt_order->insert_id; // Get the order ID after insertion

// Insert the ordered items into the order_items table
$query_order_items = "INSERT INTO order_items (order_id, book_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt_order_items = $conn->prepare($query_order_items);

// Loop through the cart items and insert each item into the order_items table
foreach ($cart_items as $item) {
    $stmt_order_items->bind_param('iiid', $order_id, $item['book_id'], $item['quantity'], $item['price']);
    $stmt_order_items->execute();
}

// Optionally, clear the cart after order placement
$query_clear_cart = "DELETE FROM cart WHERE user_id = ?";
$stmt_clear_cart = $conn->prepare($query_clear_cart);
$stmt_clear_cart->bind_param('i', $user_id);
$stmt_clear_cart->execute();

// Redirect to a confirmation page or show a success message
header("Location: order_confirmation.php?order_id=" . $order_id);
exit();
?>
