<?php
require 'db.php';
$products = [];
$result = $conn->query('SELECT * FROM products');

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="morestyle.css" />
  <title>🏷️ Shopping Page | Project</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">TechWorld</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Browse</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cart.php">Cart</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

    <div class="container-fluid text-center d-flex flex-row justify-content-center flex-wrap gap-2">

      <?php foreach ($products  as $product) : ?>
        <div class="card" style="width: 18rem">
          <img src="assets/<?= $product['ImageRef'] ?>" class="card-img-top" alt="digital camera" />
          <div class="card-body text-center">
            <h5 class="card-title"><?= $product['name'] ?></h5>
            <p class="card-text">$<?= $product['price'] ?></p>
            <form action="product.php" method="post">
              <button type="submit" class="btn btn-primary">
                View Product
                <input type="hidden" name="product_topage_id" value="<?= $product['id'] ?>">
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>


    </div>

  <footer class="container-fluid d-flex flex-row justify-content-center mt-5">
    <p>&copy; 2024 TechWord Rights Reserved. Made by Jovius</p>
  </footer>

</body>

</html>