<?php
include 'db_connect.php';

$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

$query = "SELECT * FROM products WHERE 1=1";
if ($category) {
    $category = str_replace('-', ' ', $category);
    $query .= " AND category = ?";
}

// Add sorting
switch ($sort) {
    case 'price-low':
        $query .= " ORDER BY price ASC";
        break;
    case 'price-high':
        $query .= " ORDER BY price DESC";
        break;
    case 'newest':
    default:
        $query .= " ORDER BY date_added DESC";
        break;
}
$stmt = $conn->prepare($query);

if ($category) {
    $stmt->bind_param("s", $category);
}

$stmt->execute();
$result = $stmt->get_result();

$products = array();
while($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode($products);

$stmt->close();
$conn->close();
?>

