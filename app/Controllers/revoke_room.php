<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$studentId = $data['studentId'] ?? null;

try {
    if (!$studentId) {
        throw new Exception("Missing studentId parameter.");
    }

    $pdo->beginTransaction();

    // 1. Find the room assigned to the student
    $stmtFindRoom = $pdo->prepare("SELECT RoomID, RoomName FROM room WHERE StudentID = :studentId");
    $stmtFindRoom->execute([':studentId' => $studentId]);
    $room = $stmtFindRoom->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        // 2. Set the room as unoccupied
        $stmtUpdateRoom = $pdo->prepare("UPDATE room SET StudentID = NULL, Occupied = 0 WHERE RoomID = :roomId");
        $stmtUpdateRoom->execute([':roomId' => $room['RoomID']]);
    }

    // 3. Update the student's Room to 'N/A'
    $stmtUpdateStudent = $pdo->prepare("UPDATE student SET Room = 'N/A' WHERE StudentID = :studentId");
    $stmtUpdateStudent->execute([':studentId' => $studentId]);

    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['error' => $e->getMessage()]);
}
