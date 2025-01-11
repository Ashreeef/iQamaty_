<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    $data = $_POST;

    // Normalize the room number to the format L9-99 or L9-09
    $roomPattern = '/^([A-Ea-e]\d)[\s-]?(\d{1,2})$/';
    if (preg_match($roomPattern, $data['Room'], $matches)) {
        $roomBlock = strtoupper($matches[1]); // Uppercase the block (e.g., A1)
        $roomNumber = str_pad($matches[2], 2, '0', STR_PAD_LEFT); // Ensure two digits
        $data['Room'] = $roomBlock . '-' . $roomNumber; // Normalize the format
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid room format.']);
        exit;
    }

    // Insert into the 'user' table
    $sqlUser = "INSERT INTO user (FirstName, LastName, Email, Password, PhoneNumber, Role) 
                VALUES (:FirstName, :LastName, :Email, :Password, :PhoneNumber, 'student')";

    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute([
        ':FirstName' => $data['FirstName'],
        ':LastName' => $data['LastName'],
        ':Email' => $data['Email'],
        ':Password' => password_hash($data['Password'], PASSWORD_DEFAULT),
        ':PhoneNumber' => $data['PhoneNumber']
    ]);
    

    $userID = $pdo->lastInsertId();

    // Insert into 'student' table
    $sqlStudent = "INSERT INTO student (StudentID, UserID, School, Room, Wilaya) 
                   VALUES (:StudentID, :UserID, :School, :Room, :Wilaya)";
    $stmtStudent = $pdo->prepare($sqlStudent);
    $stmtStudent->execute([
        ':StudentID' => $data['StudentID'],
        ':UserID' => $userID,
        ':School' => $data['School'],
        ':Room' => $data['Room'],
        ':Wilaya' => $data['Wilaya']
    ]);

    // Update the room table to mark the room as occupied and link it to this student
    $sqlRoom = "UPDATE room
                SET Occupied = 1, StudentID = :StudentID
                WHERE RoomName = :RoomName";
    $stmtRoom = $pdo->prepare($sqlRoom);
    $stmtRoom->execute([
        ':StudentID' => $data['StudentID'],
        ':RoomName' => $data['Room']
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
