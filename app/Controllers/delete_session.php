<?php
require_once '../../database/db.php'; // Adjust path as needed

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $teamID = $data['TeamID'] ?? null;  // Expecting TeamID as an integer

    if ($teamID) {
        // Use only the TeamID to delete all related sessions
        $sql = "DELETE FROM training_sessions WHERE TeamID = :TeamID";
        $stmt = $pdo->prepare($sql);

        // Bind parameter for TeamID
        $stmt->execute(['TeamID' => $teamID]);

        // Check if any rows were affected (meaning sessions were deleted)
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Training session(s) deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No sessions found for the given TeamID.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid TeamID.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
