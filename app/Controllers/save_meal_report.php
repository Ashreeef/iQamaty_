<?php
require_once '../../database/db.php'; // Adjust the path as needed

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Retrieve and validate input data
        $studentID = isset($_POST['StudentID']) ? intval($_POST['StudentID']) : null;
        $description = isset($_POST['MRDescription']) ? htmlspecialchars(trim($_POST['MRDescription'])) : null;

        if (empty($studentID) || empty($description)) {
            throw new Exception("Student ID and description are required.");
        }

        // Check if the student exists
        $studentCheckStmt = $pdo->prepare("SELECT StudentID FROM student WHERE StudentID = :StudentID");
        $studentCheckStmt->execute([':StudentID' => $studentID]);
        if ($studentCheckStmt->rowCount() === 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Student does not exist.',
            ]);
            exit;
        }

        // Handle file upload
        $attachment = null;
        if (isset($_FILES['Attachment']) && $_FILES['Attachment']['error'] === UPLOAD_ERR_OK) {
            // Validate file size (max 5MB)
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['Attachment']['size'] > $maxFileSize) {
                throw new Exception("File size exceeds the maximum limit of 5MB.");
            }

            // Validate file type
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
            if (!in_array($_FILES['Attachment']['type'], $allowedMimeTypes)) {
                throw new Exception("Only JPEG, PNG, GIF images, and MP4 videos are allowed.");
            }

            // Move the file to the uploads folder
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "\iQamaty_10\public\uploads";
            $fileExtension = pathinfo($_FILES['Attachment']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid("report_", true) . "." . $fileExtension;
            $filePath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['Attachment']['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload the file.");
            }

            // Save the file path for the database
            $attachment = "\iQamaty_10\public\uploads" . $fileName;
        }

        // Get the current date and time
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        // Insert the data into the database
        $sql = "INSERT INTO meal_report (StudentID, MRDescription, Attachment, MRDate, MRTime)
                VALUES (:StudentID, :MRDescription, :Attachment, :MRDate, :MRTime)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':StudentID' => $studentID,
            ':MRDescription' => $description,
            ':Attachment' => $attachment,
            ':MRDate' => $currentDate,
            ':MRTime' => $currentTime,
        ]);

        echo json_encode(['success' => true, 'message' => 'Meal report submitted successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>