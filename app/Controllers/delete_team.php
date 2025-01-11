<?php
require_once '../../database/db.php'; // Adjust path as needed

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $teamID = $data['TeamID'] ?? null;

    if ($teamID) {
        $sql = "DELETE FROM sport_team WHERE TeamID = :TeamID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['TeamID' => $teamID]);

        echo json_encode(['success' => true, 'message' => 'Team deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Team ID.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
