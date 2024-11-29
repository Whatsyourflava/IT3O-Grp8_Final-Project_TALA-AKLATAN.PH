<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: bookstore.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $price = floatval($_POST['price']);
    
    $query = "INSERT INTO books (title, description, price) VALUES ('$title', '$description', '$price')";
    mysqli_query($conn, $query);
}
?>
<h2>Admin Dashboard</h2>
<form method="POST" action="admin.php">
    <input type="text" name="title" placeholder="Book Title" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <input type="number" name="price" placeholder="Price" required>
    <button type="submit">Add Book</button>
</form>
