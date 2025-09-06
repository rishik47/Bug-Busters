<?php
session_start();
include 'db.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// fetch categories for filter chips
$cats = $conn->query("SELECT id,name FROM categories ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EcoFinds - Sustainable Marketplace</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body style="font-family: Poppins, sans-serif;">
<div class="page-bg"></div>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🌱 EcoFinds</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['username'])): ?>
          <li class="nav-item"><a class="nav-link" href="add_product.php">➕ Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="cart.php">🛒 Cart</a></li>
          <li class="nav-item"><a class="nav-link" href="purchases.php">📦 Purchases</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">🚪 Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="login.php">🔑 Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.php">📝 Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Banner / Hero -->
<div class="container my-4">
  <div class="hero">
    <div class="hero-card">
      <h1>Buy Pre-Loved. Save Money. Save the Planet.</h1>
      <p>Discover quality second-hand finds across electronics, books, fashion & more.</p>
      <div class="mt-3 d-flex gap-2">
        <a href="add_product.php" class="btn btn-warning rounded-pill fw-semibold">Sell an Item</a>
        <a href="#listings" class="btn btn-light rounded-pill fw-semibold">Browse Deals</a>
      </div>
    </div>
    <div class="hero-art p-3 text-center">
      <img src="images/placeholder.png" style="max-width:100%; height:290px; object-fit:cover;" alt="">
    </div>
  </div>
</div>

<!-- Search -->
<div class="container mb-3">
  <form class="d-flex" method="get" action="">
    <input class="form-control rounded-pill me-2" type="text" name="search" placeholder="🔍 Search by title..." value="<?php echo htmlspecialchars($search); ?>">
    <?php if($category_id): ?>
      <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
    <?php endif; ?>
    <button class="btn btn-success rounded-pill">Search</button>
  </form>
</div>

<!-- Category chips -->
<div class="container mb-4">
  <div class="d-flex flex-wrap gap-2">
    <a class="btn btn-outline-success btn-sm rounded-pill <?php echo $category_id? '' : 'active'; ?>" href="index.php">All</a>
    <?php while($c = $cats->fetch_assoc()): ?>
      <a class="btn btn-outline-success btn-sm rounded-pill <?php echo ($category_id==$c['id'])?'active':''; ?>"
         href="index.php?category_id=<?php echo (int)$c['id']; ?><?php echo $search? '&search='.urlencode($search):''; ?>">
         <?php echo htmlspecialchars($c['name']); ?>
      </a>
    <?php endwhile; ?>
  </div>
</div>

<!-- Product Grid -->
<div id="listings" class="container">
  <div class="row g-4">
    <?php
      $where = " WHERE 1 ";
      if($category_id) $where .= " AND p.category_id=".$category_id." ";
      if($search!==''){
        $s = $conn->real_escape_string($search);
        $where .= " AND p.title LIKE '%$s%' ";
      }
      $sql = "SELECT p.*, c.name AS category_name
              FROM products p
              JOIN categories c ON c.id=p.category_id
              $where
              ORDER BY p.created_at DESC";
      $result = $conn->query($sql);

      if($result && $result->num_rows){
        while($row = $result->fetch_assoc()){
          $img = "images/".($row['image'] ?: 'placeholder.png');
          if(!file_exists($img)) $img = "images/placeholder.png";
          echo '<div class="col-6 col-md-4 col-lg-3">
                  <div class="card shadow-sm h-100 border-0 rounded-4">
                    <img src="'.$img.'" class="card-img-top p-3" style="height:200px;object-fit:cover;border-radius:20px" alt="">
                    <div class="card-body text-center">
                      <h5 class="card-title fw-bold">'.htmlspecialchars($row['title']).'</h5>
                      <p class="text-success fw-bold mb-1">₹'.number_format($row['price'],0).'</p>
                      <span class="badge bg-light text-dark">'.htmlspecialchars($row['category_name']).'</span><br>
                      <a href="product_detail.php?id='.$row['id'].'" class="btn btn-sm btn-outline-success rounded-pill mt-2">View Details</a>
                    </div>
                  </div>
                </div>';
        }
      } else {
        echo "<p class='text-center text-muted'>No products found</p>";
      }
    ?>
  </div>
</div>

<footer class="bg-success text-white text-center p-3 mt-5">
  <p class="mb-0">© <?php echo date('Y'); ?> EcoFinds — Buy & Sell Sustainably 🌍</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
