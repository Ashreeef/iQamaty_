<?php
require_once '../../database/db.php'; // Adjust the path as needed

header('Content-Type: application/json');

try {
    // Get the raw POST data
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['TeamID'], $input['TSDay'], $input['TSTime'], $input['CoachName'])) {
        $teamID = intval($input['TeamID']);
        $tsDay = $input['TSDay'];
        $tsTime = $input['TSTime'];
        $coachName = $input['CoachName'];

        // Prepare the query
        $stmt = $pdo->prepare("
            INSERT INTO training_sessions (TeamID, TSDay, TSTime, CoachName)
            VALUES (:TeamID, :TSDay, :TSTime, :CoachName)
        ");
        $stmt->execute([
            ':TeamID' => $teamID,
            ':TSDay' => $tsDay,
            ':TSTime' => $tsTime,
            ':CoachName' => $coachName,
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Training session saved successfully.',
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid input data.',
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage(),
    ]);
}
