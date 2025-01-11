<?php
require_once '../../database/db.php'; 

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Fetch reports from the database
    $sql = "SELECT ReportID, FullName, RoomNumber, Category, Description, Date, Urgency, FileUploaded FROM report ORDER BY Date DESC, Time DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Fetch all reports
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if reports are fetched
    if ($reports) {
        echo json_encode($reports); // Return the reports as JSON
    } else {
        echo json_encode(['message' => 'No reports found.']);
    }
} catch (Exception $e) {
    // Handle any errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
