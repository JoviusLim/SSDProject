<?php
require 'db.php';

// Get Product Data
if ($_SERVER['REQUEST_METHOD'] == "POST" & isset($_POST['product_topage_id'])) {
  $product_id = $_POST["product_topage_id"];
  $result = $conn->execute_query('SELECT * FROM products WHERE id = ?', [$product_id]);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $product[] = $row;
    }
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="morestyle.css" />
  <title><?php echo $product[0]['name'] ?> | Project</title>
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
              <a class="nav-link" href="cart.html">Cart</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <div class="containter text-wrap fw-medium d-flex flex-row flex-nowrap justify-content-center m-5">
    <img src="assets/<?php echo $product[0]['ImageRef']?>" alt="<?php echo $product[0]['name'] ?>" class="w-25 me-5">
    <form action="server.php" method="post" class="ms-5">
      <p class="fs-2"><?php echo $product[0]['name'] ?></p>
      <p class="fs-5">$<?php echo $product[0]['price'] ?></p>
      <p class="fs-6"><?php echo $product[0]['Description'] ?></p>
      <input type="number" name="product_quantity" id="" value="1"> <br>
      <input type="hidden" name="product_id" value="<?php echo $product[0]['id'] ?>">
      <input type="hidden" name="product_name" value="<?php echo $product[0]['name'] ?>">
      <input type="hidden" name="product_price" value="<?php echo $product[0]['price'] ?>">
      <input type="submit" value="ADD TO CART" class="btn btn-secondary mt-2 fw-bold ps-5 pe-5 ">
    </form>
  </div>
</body>
</html>