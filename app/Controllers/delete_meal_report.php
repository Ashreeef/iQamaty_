<?php
require_once '../../database/db.php'; 

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $reportID = isset($_POST['ReportID']) ? intval($_POST['ReportID']) : null;

        if (empty($reportID)) {
            throw new Exception("Report ID is required.");
        }

        // Delete the report from the database
        $sql = "DELETE FROM meal_report WHERE ReportID = :ReportID";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':ReportID' => $reportID]);

        echo json_encode(['success' => true, 'message' => 'Report successfully marked as resolved.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>