<?php
session_start();
include 'db.php';
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
$user_id = (int)$_SESSION['user_id'];

$cats = $conn->query("SELECT id,name FROM categories ORDER BY name ASC");

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $price = (float)$_POST['price'];
  $category_id = (int)$_POST['category_id'];

  // handle image upload
  $image = 'placeholder.png';
  if(isset($_FILES['image']) && $_FILES['image']['error']===UPLOAD_ERR_OK){
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    if(in_array($ext, ['png','jpg','jpeg','webp'])){
      $image = time().'_'.preg_replace('/[^a-z0-9\.-]/i','', $_FILES['image']['name']);
      move_uploaded_file($_FILES['image']['tmp_name'], __DIR__."/images/".$image);
    }
  }

  if($title && $price>0 && $category_id){
    $titleEsc = $conn->real_escape_string($title);
    $descEsc  = $conn->real_escape_string($description);
    $conn->query("INSERT INTO products (user_id,title,description,category_id,price,image)
                  VALUES ($user_id,'$titleEsc','$descEsc',$category_id,$price,'$image')");
    header("Location: index.php");
    exit;
  } else {
    $msg = "Please fill all fields correctly.";
  }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Product - EcoFinds</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body style="font-family:Poppins, sans-serif;">
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🌱 EcoFinds</a>
  </div>
</nav>

<div class="container my-4" style="max-width:800px;">
  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <h4 class="fw-bold mb-3">Add New Product</h4>
      <?php if($msg): ?><div class="alert alert-warning py-2"><?php echo $msg; ?></div><?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Product Title</label>
            <input name="title" class="form-control rounded-3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select rounded-3" required>
              <option value="">Choose...</option>
              <?php while($c=$cats->fetch_assoc()): ?>
                <option value="<?php echo (int)$c['id']; ?>"><?php echo htmlspecialchars($c['name']); ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Price (₹)</label>
            <input name="price" type="number" step="0.01" min="1" class="form-control rounded-3" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Image</label>
            <input type="file" name="image" accept=".png,.jpg,.jpeg,.webp" class="form-control rounded-3">
          </div>
          <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control rounded-3" placeholder="Condition, brand, size, etc."></textarea>
          </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <a href="index.php" class="btn btn-outline-secondary rounded-pill">Cancel</a>
          <button class="btn btn-success rounded-pill px-4">Submit Listing</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
