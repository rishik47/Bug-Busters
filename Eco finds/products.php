<?php
session_start();
include 'db.php';

// Fetch all products
$sql = "SELECT p.id, p.title, p.description, p.price, p.image, c.name AS category
        FROM products p
        JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Products - EcoFinds</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { width: 90%; margin: 20px auto; }
        h2 { text-align: center; margin-bottom: 20px; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 180px; object-fit: cover; border-radius: 6px; }
        .card h3 { margin: 10px 0; font-size: 18px; }
        .card p { font-size: 14px; color: #555; }
        .price { font-weight: bold; margin: 10px 0; }
        .btn { display: inline-block; padding: 8px 12px; background: #28a745; color: white; border-radius: 5px; text-decoration: none; }
        .btn:hover { background: #218838; }
    </style>
</head>
<body>

<div class="container">
    <h2>Available Products</h2>
    <div class="products">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo substr($row['description'], 0, 60); ?>...</p>
                <p class="price">₹<?php echo $row['price']; ?></p>
                <a href="product_detail.php?id=<?php echo $row['id']; ?>" class="btn">View Details</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
