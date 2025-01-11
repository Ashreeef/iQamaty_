<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT RoomID, RoomName FROM room WHERE Occupied = 0 ORDER BY RoomName";
    $stmt = $pdo->query($sql);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($rooms) {
        echo json_encode($rooms);
    } else {
        echo json_encode([]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
