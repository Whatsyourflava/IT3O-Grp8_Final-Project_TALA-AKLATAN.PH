<?php
$conn = mysqli_connect("localhost", "root", "", "online_bookstore");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>