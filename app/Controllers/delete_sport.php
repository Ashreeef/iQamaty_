<?php
require_once '../../database/db.php'; // Adjust path as needed

header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $sportID = $data['SportID'] ?? null;

    if ($sportID) {
        $sql = "DELETE FROM sport WHERE SportID = :SportID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['SportID' => $sportID]);

        echo json_encode(['success' => true, 'message' => 'Sport deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Sport ID.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
