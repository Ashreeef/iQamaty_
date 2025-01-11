<?php
require_once '../../database/db.php';

// Set the response header to JSON
header('Content-Type: application/json');

// Check if EventID is provided and valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EventID'])) {
    // Sanitize and validate EventID
    $eventID = isset($_POST['EventID']) ? intval($_POST['EventID']) : null;

    if ($eventID === null || $eventID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid EventID provided.']);
        exit();
    }

    try {
        // Prepare the SQL query to delete the event from the database
        $sql = "DELETE FROM event WHERE EventID = :eventID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':eventID', $eventID, PDO::PARAM_INT);

        // Execute the query and check for successful deletion
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Event deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete event.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or EventID missing.']);
}
?>
