<?php
require_once '../../database/db.php'; // Adjust the path based on your setup

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decode JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (empty($input['StudentID']) || empty($input['TeamID'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Student ID and Team ID are required.',
            ]);
            exit;
        }

        // Check if the student exists
        $studentCheckStmt = $pdo->prepare("SELECT StudentID FROM student WHERE StudentID = :StudentID");
        $studentCheckStmt->execute([':StudentID' => $input['StudentID']]);
        if ($studentCheckStmt->rowCount() === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Student does not exist.',
            ]);
            exit;
        }

        // Insert into team_members
        $stmt = $pdo->prepare("
            INSERT INTO team_members (TeamID, StudentID, TMDate) 
            VALUES (:TeamID, :StudentID, NOW())
        ");
        $stmt->execute([
            ':TeamID' => $input['TeamID'],
            ':StudentID' => $input['StudentID'],
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Student added to the team successfully.',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method.',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
    ]);
}
?>
