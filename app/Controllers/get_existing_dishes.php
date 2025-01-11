<?php
require_once '../../database/db.php'; // Adjust the path to your database connection file

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Query to fetch all dishes
    $sql = "SELECT DishID, DName, DType FROM dishes";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Fetch all dishes
    $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the dishes as JSON
    echo json_encode(['success' => true, 'data' => $dishes]);
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
