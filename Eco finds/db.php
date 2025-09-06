<?php
// Database config
$servername = "localhost";
$username   = "root";
$password   = "";
$port       = 3307;  // Adjust if your MySQL runs on another port
$dbname     = "ecofinds";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8 for proper encoding
$conn->set_charset("utf8mb4");
?>
