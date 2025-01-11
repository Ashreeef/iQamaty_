<?php

require_once '../../database/db.php'; // Adjust the path to your database connection file
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Read input from POST request
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['day']) || !isset($input['mealType']) || !isset($input['dishes'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid input. Day, mealType, and dishes data are required.'
            ]);
            exit;
        }

        $day = ucfirst(strtolower($input['day']));
        $mealType = ucfirst(strtolower($input['mealType']));
        $dishes = $input['dishes']; // Contains mainID, secondaryID, dessertID

        // Validate dishes
        if (!isset($dishes['main'], $dishes['secondary'], $dishes['dessert'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid dishes data. All dish IDs are required.'
            ]);
            exit;
        }

        // Start a transaction
        $pdo->beginTransaction();

        // Delete the existing meal for the specified day and type
        $stmt = $pdo->prepare("DELETE FROM menu WHERE dayOfWeek = :day AND MType = :mealType");
        $stmt->execute([
            ':day' => $day,
            ':mealType' => $mealType,
        ]);

        // Insert the new meal
        $insertStmt = $pdo->prepare(
            "INSERT INTO menu (MType, dayOfWeek, mainID, secondaryID, dessertID) 
             VALUES (:MType, :dayOfWeek, :mainID, :secondaryID, :dessertID)"
        );

        $insertStmt->execute([
            ':MType' => $mealType,
            ':dayOfWeek' => $day,
            ':mainID' => $dishes['main'],
            ':secondaryID' => $dishes['secondary'],
            ':dessertID' => $dishes['dessert'],
        ]);

        // Commit the transaction
        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Meal saved successfully.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method. Only POST requests are allowed.'
        ]);
    }
} catch (Exception $e) {
    // Roll back transaction if something goes wrong
    $pdo->rollBack();

    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
    ]);
}
?>
