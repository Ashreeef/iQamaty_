<?php
require_once '../../database/db.php';

// Set the content type to JSON
header('Content-Type: application/json');

// Check if the ReportID is provided in the request
if (isset($_POST['ReportID'])) {
    $reportID = intval($_POST['ReportID']);

    try {
        // Delete the report with the provided ReportID
        $sql = "DELETE FROM report WHERE ReportID = :reportID";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':reportID', $reportID, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Report successfully deleted.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete report.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No ReportID provided.']);
}
?>
