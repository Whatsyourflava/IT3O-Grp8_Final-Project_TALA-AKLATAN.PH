<?php
session_start();

// Check if cart is set and count the items
echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
