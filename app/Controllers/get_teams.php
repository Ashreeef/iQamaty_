<?php
require_once '../../database/db.php'; // Adjust the path based on your setup

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT t.TeamID, t.TName, s.SName AS SportName
        FROM sport_team t
        JOIN sport s ON t.SportID = s.SportID
        ORDER BY t.TName ASC
    ");
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $teams,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
    ]);
}
?>
