<?php
include 'db_connect.php';

$category = isset($_GET['category']) ? $_GET['category'] : null;

// Prepare the SQL query
if ($category) {
    $sql = "SELECT * FROM products WHERE category = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
} else {
    $sql = "SELECT * FROM products";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>

