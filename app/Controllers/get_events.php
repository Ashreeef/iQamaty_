<?php
require_once '../../database/db.php';

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Prepare and execute the query to fetch events ordered by EventDate ascending
    $sql = "SELECT EventID, EventName, EventDate, EventLocation, EventDetails, EventFormLink, EventPicture, isRegister 
            FROM event 
            ORDER BY EventDate ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Fetch all events
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if events are fetched
    if ($events) {
        // Return the events as JSON
        echo json_encode($events);
    } else {
        // No events found
        echo json_encode(['message' => 'No events found.']);
    }
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
