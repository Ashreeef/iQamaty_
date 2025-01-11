<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    $sql = "
        SELECT 
            r.RoomID,
            r.RoomName,
            r.Occupied,
            CONCAT(u.FirstName, ' ', u.LastName) AS OccupantName
        FROM room r
        LEFT JOIN student s ON r.StudentID = s.StudentID
        LEFT JOIN user u ON s.UserID = u.UserID
        ORDER BY r.RoomName;
    ";
    $stmt = $pdo->query($sql);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rooms) {
        echo json_encode($rooms);
    } else {
        echo json_encode(['message' => 'No rooms found.']);
    }

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
