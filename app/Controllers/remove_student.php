<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents("php://input"), true);
    $studentId = $data['studentId'] ?? null;

    if (!$studentId) {
        throw new Exception("No student ID provided.");
    }

    // Find the student's userID & room
    $stmtFind = $pdo->prepare("SELECT UserID, Room FROM student WHERE StudentID = :studentId");
    $stmtFind->execute([':studentId' => $studentId]);
    $student = $stmtFind->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        throw new Exception("Student not found.");
    }

    // Free up the room, if assigned
    if (!empty($student['Room'])) {
        $stmtRoom = $pdo->prepare("UPDATE room SET Occupied = 0, StudentID = NULL WHERE RoomName = :roomName");
        $stmtRoom->execute([':roomName' => $student['Room']]);
    }

    // Remove from `student`
    $stmtDeleteStudent = $pdo->prepare("DELETE FROM student WHERE StudentID = :studentId");
    $stmtDeleteStudent->execute([':studentId' => $studentId]);

    // Remove from `user`
    $stmtDeleteUser = $pdo->prepare("DELETE FROM user WHERE UserID = :userId");
    $stmtDeleteUser->execute([':userId' => $student['UserID']]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
