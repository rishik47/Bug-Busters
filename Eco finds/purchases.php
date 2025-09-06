<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch all purchases of the logged-in user
$sql = "SELECT p.id, pr.title, pr.price, pr.image, c.name AS category, p.purchase_date
        FROM purchases p
        JOIN products pr ON p.product_id = pr.id
        JOIN categories c ON pr.category_id = c.id
        WHERE p.user_id = ?
        ORDER BY p.purchase_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Purchases - EcoFinds</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; }
        .container { width: 90%; margin: 30px auto; }
        h2 { text-align: center; margin-bottom: 20px; }
        .purchases { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 8px; padding: 15px; text-align: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .card img { width: 100%; height: 180px; object-fit: cover; border-radius: 6px; }
        .card h3 { margin: 10px 0; font-size: 18px; }
        .card p { font-size: 14px; color: #555; }
        .date { font-size: 13px; color: #777; margin-top: 8px; }
    </style>
</head>
<body>

<div class="container">
    <h2>My Purchases</h2>
    <div class="purchases">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                    <h3><?php echo $row['title']; ?></h3>
                    <p>Category: <?php echo $row['category']; ?></p>
                    <p>Price: ₹<?php echo $row['price']; ?></p>
                    <p class="date">Purchased on: <?php echo $row['purchase_date']; ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No purchases yet. <a href="products.php">Go Shopping</a></p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
