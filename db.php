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