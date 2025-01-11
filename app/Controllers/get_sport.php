<?php
require_once '../../database/db.php'; // Adjust the path as needed

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT SportID, SName, SDescription, SFormLink FROM sport ORDER BY SName ASC");
    $sports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $sports,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
    ]);
}
?>
