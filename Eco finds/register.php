<?php
session_start();
include 'db.php';
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username,email,password) VALUES ('$username','$email','$password')";
    if ($conn->query($sql)) {
        echo "<script>alert('Registered Successfully! Please Login.');window.location='login.php';</script>";
        exit;
    } else {
        $error = $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - EcoFinds</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Poppins', sans-serif;
    }
    .register-box {
      max-width: 400px;
      margin: 60px auto;
      background: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .register-box h2 {
      text-align: center;
      margin-bottom: 20px;
      font-weight: 600;
      color: #2e7d32;
    }
    .form-control {
      border-radius: 10px;
    }
    .btn-success {
      border-radius: 10px;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>📝 Register for EcoFinds</h2>
    <?php if (isset($error)) echo '<p class="text-danger text-center">'.$error.'</p>'; ?>
    <form method="post" action="">
      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required>
      </div>
      <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email" required>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="d-grid">
        <input type="submit" name="register" value="Register" class="btn btn-success">
      </div>
      <p class="mt-3 text-center">
        Already have an account? <a href="login.php" class="text-success fw-bold">Login</a>
      </p>
    </form>
  </div>
</body>
</html>
