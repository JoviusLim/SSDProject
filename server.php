<?php
require 'db.php';

// Handling cart
if ($_SERVER["REQUEST_METHOD"] == "POST" & isset($_POST["product_id"])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];

    if ($productQuantity <= 0) {
        echo "ERROR: Quantity must not be 0.";
    } else {
        $sql = 'SELECT id FROM tempcart WHERE id = ?';
        $result = $conn -> execute_query($sql, [$productId]);
        $exists = $result -> num_rows;

        if ($exists) {
            $sql = 'UPDATE tempcart SET quantity = ?+quantity WHERE id = ?';
            $result = $conn -> execute_query($sql, [$productQuantity, $productId]);
            echo "UPDATE";
        } else {    
            $sql = 'INSERT INTO tempcart (id, name, price, quantity) VALUES (?, ?, ?, ?)';
            $result = $conn -> execute_query($sql, [$productId, $productName, $productPrice, $productQuantity]);
            echo "INSERT";
        }
    }
}

$conn ->close();