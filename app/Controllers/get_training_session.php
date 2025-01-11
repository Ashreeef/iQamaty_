<?php
require_once '../../database/db.php'; // Adjust the path based on your setup

header('Content-Type: application/json');

try {
    // Fetch training sessions and join with sport_team for team names
    $stmt = $pdo->query("
        SELECT ts.TeamID, ts.TSDay, ts.TSTime, ts.CoachName, st.TName
        FROM training_sessions ts
        JOIN sport_team st ON ts.TeamID = st.TeamID
        ORDER BY ts.TSDay, ts.TSTime ASC
    ");

    $trainingSessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $trainingSessions,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
    ]);
}
?>
