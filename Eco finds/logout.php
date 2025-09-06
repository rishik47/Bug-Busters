<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Logging Out - EcoFinds</title>
  <meta http-equiv="refresh" content="2;url=login.php">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #4caf50, #2e7d32);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Poppins', sans-serif;
    }
    .logout-box {
      background: #fff;
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <div class="logout-box">
    <h2 class="text-success fw-bold">🌱 EcoFinds</h2>
    <p class="fw-semibold text-muted">You have been logged out successfully.</p>
    <div class="spinner-border text-success mt-3" role="status"></div>
    <p class="mt-3 text-muted">Redirecting to login...</p>
  </div>
</body>
</html>
