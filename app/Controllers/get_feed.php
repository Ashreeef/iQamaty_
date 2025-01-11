<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

try {
    // fetch all feed items, newest first (adjust ORDER BY as needed)
    $sql = "SELECT feed_id, feed_title, feed_admin, feed_description, feed_image, created_at
            FROM feed
            ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $feedItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($feedItems && count($feedItems) > 0) {
        echo json_encode($feedItems);
    } else {
        echo json_encode(['message' => 'No announcements found.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
