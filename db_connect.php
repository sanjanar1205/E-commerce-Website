<?php
$host = "localhost"; // Change to your database host if needed
$username = "root";  // Change if you have a different MySQL username
$password = "";      // Change if you set a password for MySQL
$dbname = "myshop_db";  // Your database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Uncomment this to test the connection
// echo "Database Connected Successfully!";
?>
