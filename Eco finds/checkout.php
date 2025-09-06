<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
$user_id = (int)$_SESSION['user_id'];

if($_SERVER['REQUEST_METHOD']==='POST'){
  // move all cart items to purchases
  $items = $conn->query("SELECT product_id FROM cart WHERE user_id=$user_id");
  while($it = $items->fetch_assoc()){
    $pid = (int)$it['product_id'];
    $conn->query("INSERT INTO purchases (user_id, product_id) VALUES ($user_id, $pid)");
  }
  $conn->query("DELETE FROM cart WHERE user_id=$user_id");
  header("Location: purchases.php");
  exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Checkout - EcoFinds</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family:Poppins, sans-serif;">
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🌱 EcoFinds</a>
  </div>
</nav>

<div class="container my-4" style="max-width:700px;">
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <h4 class="fw-bold mb-3">Checkout</h4>
      <form method="post">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input class="form-control rounded-3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Phone</label>
            <input class="form-control rounded-3" required>
          </div>
          <div class="col-12">
            <label class="form-label">Address</label>
            <textarea class="form-control rounded-3" rows="3" required></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <a href="cart.php" class="btn btn-outline-secondary rounded-pill">Back to Cart</a>
          <button class="btn btn-success rounded-pill px-4">Place Order</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
