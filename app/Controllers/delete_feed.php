<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feed_id'])) {
    // Convert feed_id to integer
    $feedID = intval($_POST['feed_id']);

    // Validate
    if ($feedID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid feed_id provided.']);
        exit();
    }

    try {
        $sql = "DELETE FROM feed WHERE feed_id = :feedID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':feedID', $feedID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Announcement deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete announcement.']);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or feed_id missing.']);
}
?>
