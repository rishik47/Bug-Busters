<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch product details
$sql = "SELECT id, title, price, image FROM products WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: products.php");
    exit;
}

$product = $result->fetch_assoc();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If already in cart, increase quantity
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['quantity'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'id' => $product['id'],
        'title' => $product['title'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => 1
    ];
}

// Redirect to cart page
header("Location: cart.php");
exit;
?>
