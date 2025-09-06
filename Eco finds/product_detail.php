<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT p.id, p.title, p.description, p.price, p.image, c.name AS category
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Product not found!";
    exit;
}

$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['title']; ?> - EcoFinds</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { width: 70%; margin: 40px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        img { width: 300px; border-radius: 8px; margin-bottom: 20px; }
        h2 { margin-bottom: 10px; }
        p { font-size: 15px; margin: 8px 0; }
        .price { font-size: 18px; font-weight: bold; color: #28a745; margin: 15px 0; }
        .btn { display: inline-block; padding: 10px 15px; background: #007bff; color: white; border-radius: 5px; text-decoration: none; margin: 5px; }
        .btn:hover { background: #0056b3; }
        .btn-green { background: #28a745; }
        .btn-green:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2><?php echo $product['title']; ?></h2>
    <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['title']; ?>">
    <p><?php echo $product['description']; ?></p>
    <p><strong>Category:</strong> <?php echo $product['category']; ?></p>
    <p class="price">Price: ₹<?php echo $product['price']; ?></p>

    <a href="add_cart.php?id=<?php echo $product['id']; ?>" class="btn btn-green">Add to Cart</a>
    <a href="Purchase.php" class="btn">Purchase</a>
</div>

</body>
</html>
