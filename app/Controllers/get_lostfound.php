<?php
require_once '../../database/db.php';

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Fetch the lost/found items
    $sql = "SELECT LFID, LFName, LFDescription, LFDate, LFLocation, LFStatus, LFPicture
            FROM lost_found 
            ORDER BY LFDate DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($items) {
        // Return the items as JSON
        echo json_encode($items);
    } else {
        // No items found
        echo json_encode(['message' => 'No items found.']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
