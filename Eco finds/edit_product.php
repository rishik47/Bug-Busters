<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id      = intval($_GET['id']); 
$user_id = $_SESSION['user_id'];

// Fetch product details safely
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found or you don't have permission to edit.";
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Handle update
if (isset($_POST['update'])) {
    $title       = $_POST['title'];
    $category    = $_POST['category'];
    $description = $_POST['description'];
    $price       = $_POST['price'];

    $stmt = $conn->prepare("UPDATE products SET title=?, category=?, description=?, price=? WHERE id=? AND user_id=?");
    $stmt->bind_param("ssssii", $title, $category, $description, $price, $id, $user_id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product - EcoFinds</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit Product</h2>
<form method="POST">
    Title: <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required><br><br>

    Category: 
    <select name="category" required>
        <option value="Electronics" <?php if($product['category']=='Electronics') echo 'selected'; ?>>Electronics</option>
        <option value="Clothing" <?php if($product['category']=='Clothing') echo 'selected'; ?>>Clothing</option>
        <option value="Books" <?php if($product['category']=='Books') echo 'selected'; ?>>Books</option>
        <option value="Furniture" <?php if($product['category']=='Furniture') echo 'selected'; ?>>Furniture</option>
    </select><br><br>

    Description: <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br><br>

    Price: <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br><br>

    <button type="submit" name="update">Update Product</button>
</form>
</body>
</html>
