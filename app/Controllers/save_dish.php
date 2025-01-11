<?php

require_once '../../database/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read input from POST request
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['dishName']) && isset($input['dishType'])) {
        $dishName = trim($input['dishName']);
        $dishType = trim($input['dishType']);

        try {
            // Insert the new dish into the database
            $stmt = $pdo->prepare("INSERT INTO dishes (DName, DType) VALUES (:dishName, :dishType)");
            $stmt->bindParam(':dishName', $dishName);
            $stmt->bindParam(':dishType', $dishType);
            $stmt->execute();

            echo json_encode([
                'success' => true,
                'message' => "Dish added successfully!",
                'dishID' => $pdo->lastInsertId()
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'success' => false,
                'message' => "Database error: " . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Invalid input. Please provide both dishName and dishType."
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => "Invalid request method. Only POST requests are allowed."
    ]);
}
?>
