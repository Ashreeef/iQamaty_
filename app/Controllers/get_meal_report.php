<?php
require_once '../../database/db.php'; 

// Set the content type to JSON
header('Content-Type: application/json');

try {
    // Fetch reports from the database with joined data
    $sql = "SELECT mr.ReportID, mr.StudentID, mr.MRDescription, mr.Attachment, mr.MRDate, mr.MRTime, 
                   u.FirstName, u.LastName, s.Room
            FROM meal_report mr
            JOIN student s ON mr.StudentID = s.StudentID
            JOIN user u ON s.UserID = u.UserID
            ORDER BY mr.MRDate DESC, mr.MRTime DESC";
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