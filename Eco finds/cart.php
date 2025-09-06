<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - EcoFinds</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { width: 80%; margin: 30px auto; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; text-align: center; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        img { width: 80px; height: 80px; object-fit: cover; border-radius: 6px; }
        .btn { padding: 6px 10px; background: #dc3545; color: white; border-radius: 5px; text-decoration: none; }
        .btn:hover { background: #b52a37; }
        .checkout { margin-top: 20px; text-align: right; }
        .checkout-btn { padding: 10px 15px; background: #28a745; color: white; border-radius: 5px; text-decoration: none; }
        .checkout-btn:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Your Shopping Cart</h2>

    <?php if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0): ?>
        <p>Your cart is empty. <a href="products.php">Go Shopping</a></p>
    <?php else: ?>
        <table>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            <?php 
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $item): 
                $total = $item['price'] * $item['quantity'];
                $grand_total += $total;
            ?>
            <tr>
                <td><img src="images/<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>"></td>
                <td><?php echo $item['title']; ?></td>
                <td>₹<?php echo $item['price']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td>₹<?php echo $total; ?></td>
                <td><a href="remove_cart.php?id=<?php echo $item['id']; ?>" class="btn">Remove</a></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="checkout">
            <h3>Grand Total: ₹<?php echo $grand_total; ?></h3>
            <a href="purchase.php" class="checkout-btn">Proceed to Purchase</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
