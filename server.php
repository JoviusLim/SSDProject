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
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST["add_to_cart"])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];

    $sql = 'INSERT INTO tempcart (id, name, price, quantity) VALUES ($productID, $productName, $productPrice)';
    $result = $conn -> query($sql);
}