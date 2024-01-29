<?php
$host = "localhost";
$username = "Server";
$password = "Password";
$database = "SSD_Project_Jovius";

// Connecting to database
$conn = new mysqli($host, $username, $password, $database);

if ($conn -> connect_error) {
    die("Connection Failed: ". $conn->connect_error);
}

// Handling cart
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST["product_id"])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];

    if ($productQuantity <= 0) {
        echo "ERROR: Quantity must not be 0.";
    }

    $sql = 'SELECT id FROM tempcart WHERE id = ?';
    $result = $conn -> execute_query($sql, [$productId]);
    $exists = $result -> num_rows;

    if ($exists) {
        $sql = 'UPDATE tempcart SET quantity = ?+quantity';
        $result = $conn -> execute_query($sql, [$productQuantity]);
        echo "UPDATE";
    } else {
        $sql = 'INSERT INTO tempcart (id, name, price, quantity) VALUES (?, ?, ?, ?)';
        $result = $conn -> execute_query($sql, [$productId, $productName, $productPrice, $productQuantity]);
        echo "INSERT";
    }
}