<?php
require_once '../../database/db.php'; // Adjust the path as needed

header('Content-Type: application/json');

try {
    // Fetch sports from the database
    $stmt = $pdo->query("
        SELECT SportID, SName, SLocation, SDescription, isRegister, SFormLink, SPicture
        FROM sport
        ORDER BY SName ASC
    ");
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
