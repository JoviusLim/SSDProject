<?php
require 'db.php';

// Handling cart
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST["product_id"])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];

    if ($productQuantity <= 0) {
        $resp = "Failed to Add to Cart!";
    } else {
        $sql = 'SELECT id FROM tempcart WHERE id = ?';
        $result = $conn->execute_query($sql, [$productId]);
        $exists = $result->num_rows;

        if ($exists) {
            $sql = 'UPDATE tempcart SET quantity = ?+quantity WHERE id = ?';
            $result = $conn->execute_query($sql, [$productQuantity, $productId]);
            $resp = "Sucessfully Added to Cart!";
        } else {
            $sql = 'INSERT INTO tempcart (id, name, price, quantity) VALUES (?, ?, ?, ?)';
            $result = $conn->execute_query($sql, [$productId, $productName, $productPrice, $productQuantity]);
            $resp = "Sucessfully Added to Cart!";
        }
    }
}

// Delete Cart Items
if ($_SERVER['REQUEST_METHOD'] == "POST" & isset($_POST['delete'])) {
    $productDeleteID = $_POST["delete"];
    $sql = 'DELETE FROM tempcart WHERE id = ?';
    $result = $conn->execute_query($sql, [$productDeleteID]);

    $resp = "Product ID: $productDeleteID sucessfully removed from cart!";
}

// Edit Cart Items
if ($_SERVER['REQUEST_METHOD'] == "POST" & isset($_POST['edit']) | isset($_POST['update'])) {
    if (isset($_POST['edit'])) {
        $editmode = $_POST['edit'];
    }

    if (isset($_POST['update'])) {
        $editmode = null;
        $updateid = $_POST['update'];
        $updatequantity = $_POST['updatequantity'];

        if ($updateid > 0) {
            $sql = 'UPDATE tempcart SET quantity = ? WHERE id = ?';
            $result = $conn->execute_query($sql, [$updatequantity, $updateid]);
            $resp = "Product ID: $updateid successfully updated!";
        } else {
            $resp = "Product ID: $updateid failed to update! The quantity amount must not be 0 or less.";
        }
    }
}

// Checkout
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST["Checkout"])) {
    $ProductList = [];
    
    $result = $conn->query('SELECT * FROM tempcart');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ProductList[] = $row;
        }
    }

    // Get OrderID
    $sql = "SELECT orderID FROM checkout";
    $result = $conn->query($sql);
    $orderID = 0;

    $exists = $result->num_rows;
    if ($exists) {
        $orderID = $exists+1;
    } else {
        $orderID = 1;
    }

    foreach ($ProductList as $products) {
        $sql = "INSERT INTO checkout (orderID,product_id, product_name, product_price, product_quantity) VALUES (?,?,?,?,?)";
        $result = $conn->execute_query($sql, [$orderID,$products['id'], $products['name'], $products['price'], $products['quantity']]);
        $sqlremove = "DELETE FROM tempcart WHERE id = ?";
        $result = $conn->execute_query($sqlremove, [$products['id']]);
    }

    $resp = 'Successful Checkout!';
}

// Get Total Price of Cart
function GetTotal($cartList)
{
    $totalPrice = 0;
    foreach ($cartList as $productInCart) {
        $totalPrice = ($productInCart['price'] * $productInCart['quantity']) + $totalPrice;
    }
    return $totalPrice;
}

// Getting the items in the cart
$cartList = [];
$resultTempCart = $conn->query('SELECT * FROM tempcart');

if ($resultTempCart->num_rows > 0) {
    while ($row = $resultTempCart->fetch_assoc()) {
        $cartList[] = $row;
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
    <title>🏷️ Cart Page | Project</title>
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
        <?php if (isset($resp)) : ?>
            <div class="alert alert-info" role="alert">
                <?php echo $resp ?>
            </div>
        <?php endif; ?>
    </header>

    <div class="container-fluid">
        <?php if ($resultTempCart->num_rows > 0) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartList as $cartProduct) : ?>
                        <tr>
                            <form action="" method="post">
                                <th scope="row"><?= $cartProduct['id'] ?></th>
                                <td><?= $cartProduct['name'] ?></td>
                                <td>$<?= $cartProduct['price'] ?></td>
                                <td>
                                    <?php if (isset($editmode)) : ?>
                                        <?php if ($editmode == $cartProduct['id']) : ?>
                                            <input type="number" name="updatequantity" value="<?= $cartProduct['quantity'] ?>">
                                        <?php else : ?>
                                            <?= $cartProduct['quantity'] ?>
                                        <?php endif; ?>
                                    <?php else : ?>
                                        <?= $cartProduct['quantity'] ?>
                                    <?php endif; ?>
                                </td>
                                <?php if (isset($editmode)) : ?>
                                    <?php if ($editmode == $cartProduct['id']) : ?>
                                        <td><button class="btn btn-primary" type="submit" name='update' value='<?= $cartProduct['id'] ?>'>UPDATE</button></td>
                                    <?php else : ?>
                                        <td><button class="btn btn-primary" type="submit" name='edit' value='<?= $cartProduct['id'] ?>'>EDIT</button></td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <td><button class="btn btn-primary" type="submit" name='edit' value='<?= $cartProduct['id'] ?>'>EDIT</button></td>
                                <?php endif; ?>
                                <td><button class="btn btn-danger" type="submit" name='delete' value='<?= $cartProduct['id'] ?>'>DELETE</button></td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <table class="table justify-content-evenly container">
                <thead>
                    <tr>
                        <th scope="col">Total Price</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <form action="" method="post">
                            <td>$<?php echo GetTotal($cartList) ?></td>
                            <td><button class="btn btn-success" type="submit" name='Checkout' value='checkout'>Checkout</button></td>
                        </form>
                    </tr>
                </tbody>
            </table>
        <?php else : ?>
            <h1 class="text-center d-flex flex-row justify-content-center mt-5">Your Cart is empty!</h1>
            <form action="index.php" class="text-center d-flex flex-row justify-content-center mt-5">
                <button type="submit" class="btn btn-primary fw-bold">Go Shopping!</button>
            </form>
        <?php endif; ?>
    </div>

</body>

</html>