<?php
session_start();
include 'db.php';

// Check if user is logged in and id is provided
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id       = intval($_GET['id']); // Cast to int for safety
$user_id  = $_SESSION['user_id'];

// Prepared statement to prevent SQL injection
$stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: index.php");
exit;
?>
