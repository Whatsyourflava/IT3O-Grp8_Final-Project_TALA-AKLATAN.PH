<?php
session_start(); // Start the session
include 'db.php'; // Include the database connection

// Check if the user is logged in and if the required form data is sent
if (isset($_POST['book_id']) && isset($_POST['quantity']) && isset($_SESSION['user'])) {
    $book_id = $_POST['book_id']; // Get the book ID from the POST data
    $quantity = $_POST['quantity']; // Get the quantity from the POST data
    $user_id = $_SESSION['user']['id']; // Get the user ID from the session (user info is stored after login)

    // Check if the cart session exists; if not, create an empty cart
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the book is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['book_id'] == $book_id) {
            // If the book is found, update the quantity
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }

    // If the book is not found in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = [
            'book_id' => $book_id,
            'quantity' => $quantity
        ];
    }

    // Now insert the item into the cart table in the database
    $query = "INSERT INTO cart (user_id, book_id, quantity, added_at) 
              VALUES ('$user_id', '$book_id', '$quantity', NOW())";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Success message (optional)
        echo "Item added to your cart!";
    } else {
        // Error handling
        echo "Error adding item to the cart: " . mysqli_error($conn);
    }

    // Redirect to the bookstore page or any page you want to navigate to after adding to the cart
    header("Location: bookstore.php");
    exit();
} else {
    // If no data was posted or user is not logged in, redirect back to bookstore
    header("Location: bookstore.php");
    exit();
}
?>
