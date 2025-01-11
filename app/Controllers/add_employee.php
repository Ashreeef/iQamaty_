<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

try {
    $data = $_POST;

    if (empty($data['FirstName']) || empty($data['LastName']) || empty($data['Email']) || empty($data['Password']) || empty($data['PhoneNumber'])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }
    

    // Insert into the 'user' table
    $sqlUser = "INSERT INTO user (FirstName, LastName, Email, Password, PhoneNumber, Role) 
                VALUES (:FirstName, :LastName, :Email, :Password, :PhoneNumber, 'staff')";

    $stmtUser = $pdo->prepare($sqlUser);
    $stmtUser->execute([
        ':FirstName' => $data['FirstName'],
        ':LastName' => $data['LastName'],
        ':Email' => $data['Email'],
        ':Password' => password_hash($data['Password'], PASSWORD_DEFAULT),
        ':PhoneNumber' => $data['PhoneNumber']
    ]);

    $userID = $pdo->lastInsertId();

    // Insert into 'admin' table
    $sqlAdmin = "INSERT INTO admin (UserID) 
                   VALUES (:UserID)";
    $stmtAdmin = $pdo->prepare($sqlAdmin);
    $stmtAdmin->execute([
        ':UserID' => $userID
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
