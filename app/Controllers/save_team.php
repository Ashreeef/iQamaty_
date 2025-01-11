<?php
require_once '../../database/db.php'; // Adjust the path as needed

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Decode JSON input
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate required fields
        if (empty($input['TName']) || empty($input['SportID'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Team Name and Sport ID are required.',
            ]);
            exit;
        }

        // Insert the new team into the database
        $stmt = $pdo->prepare("INSERT INTO sport_team (SportID, TName) VALUES (:SportID, :TName)");
        $stmt->execute([
            ':SportID' => $input['SportID'],
            ':TName' => $input['TName'],
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Team added successfully.',
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
