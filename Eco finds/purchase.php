<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: cart.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Insert each cart item into purchases table
foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['id'];
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
}

// Clear cart after purchase
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Purchase Successful - EcoFinds</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; text-align: center; padding: 50px; }
        .box { background: white; padding: 30px; border-radius: 8px; display: inline-block; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        .btn { margin-top: 20px; display: inline-block; padding: 10px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 6px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="box">
        <h2>🎉 Purchase Successful!</h2>
        <p>Thank you for shopping with EcoFinds.</p>
        <a href="purchases.php" class="btn">View My Purchases</a>
        <a href="products.php" class="btn">Continue Shopping</a>
    </div>
</body>
</html>
