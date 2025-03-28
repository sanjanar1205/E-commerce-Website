<?php
include 'db_connect.php';

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "No product ID provided"]);
    exit;
}

$product_id = intval($_GET['id']);

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Product not found"]);
}

$conn->close();
?>
