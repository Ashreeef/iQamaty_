<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$studentId = $data['studentId'] ?? null;
$roomId = $data['roomId'] ?? null;

try {
    if (!$studentId || !$roomId) {
        throw new Exception("Missing parameters (studentId or roomId).");
    }

    $pdo->beginTransaction();

    // 1. Update the room to set it as Occupied and link the StudentID
    $stmt = $pdo->prepare("UPDATE room SET StudentID = :studentId, Occupied = 1 WHERE RoomID = :roomId");
    $stmt->execute([
        ':studentId' => $studentId,
        ':roomId'    => $roomId
    ]);

    // 2. Also update student's Room in the student table
    $stmtRoomName = $pdo->prepare("SELECT RoomName FROM room WHERE RoomID = :roomId");
    $stmtRoomName->execute([':roomId' => $roomId]);
    $roomInfo = $stmtRoomName->fetch(PDO::FETCH_ASSOC);
    if (!$roomInfo) {
        throw new Exception("Invalid room ID.");
    }
    $roomName = $roomInfo['RoomName'];

    $stmtStudent = $pdo->prepare("UPDATE student SET Room = :roomName WHERE StudentID = :studentId");
    $stmtStudent->execute([
        ':roomName'  => $roomName,
        ':studentId' => $studentId
    ]);

    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['error' => $e->getMessage()]);
}
