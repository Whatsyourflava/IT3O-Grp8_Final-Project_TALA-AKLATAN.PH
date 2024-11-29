<?php
session_start();
include 'db.php';

// Get the order_id from the URL
$order_id = $_GET['order_id'];

// Fetch order details
$query = "
    SELECT orders.*, order_items.book_id, order_items.quantity, order_items.price, books.title, books.image
    FROM orders
    JOIN order_items ON orders.id = order_items.order_id
    JOIN books ON order_items.book_id = books.id
    WHERE orders.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the order exists
if ($result->num_rows <= 0) {
    echo "Error: Order not found.";
    exit();
}

// Fetch the order details
$order = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="styles/cart.css">
    <style>
        /* Order Confirmation Page Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: black;
            margin: 0;
            padding: 0;
        }
        
        h1 {
            color: #4CAF50;
            text-align: center;
            margin-top: 20px;
        }

        p {
            font-size: 1.1em;
            margin: 10px 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: black;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        

        img {
            max-width: 50px;
            height: auto;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
            display: block;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order! Your order has been successfully placed.</p>
    <p><strong>Order ID:</strong> <?php echo $order['id']; ?></p>
    <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
    <p><strong>Total Price:</strong> ₱<?php echo number_format($order['total_price'], 2); ?></p>

    <h1 style="padding-left: 20px;">Order Confirmation</h1>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch order items and display them
            // Since the result is already fetched, we can reset the pointer and fetch items again
            $result->data_seek(0);
            while ($item = $result->fetch_assoc()) {
                $item_total = $item['quantity'] * $item['price'];
            ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    </td>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>₱<?php echo number_format($item_total, 2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Add a "Back to Home" button -->
    <p>
        <a href="index.php">
            <button>Back to Home</button>
        </a>
    </p>
</body>
</html>
