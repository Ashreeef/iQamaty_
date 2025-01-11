<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Input sanitization and validation
        $itemName = isset($_POST['item-name']) ? htmlspecialchars(trim($_POST['item-name'])) : null;
        $itemLocation = isset($_POST['item-location']) ? htmlspecialchars(trim($_POST['item-location'])) : null;
        $itemDescription = isset($_POST['item-description']) ? htmlspecialchars(trim($_POST['item-description'])) : null;
        $itemDate = isset($_POST['item-date']) ? trim($_POST['item-date']) : null;

        // Check if required fields are provided
        if (empty($itemName) || empty($itemLocation) || empty($itemDescription) || empty($itemDate)) {
            throw new Exception("All required fields (name, location, description, date) must be filled.");
        }

        // Validate item date format (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $itemDate)) {
            throw new Exception("Invalid item date format. Please use YYYY-MM-DD.");
        }

        // Default status for reported items
        $status = 'lost';

        // Handle file upload securely
        $itemPicture = null; // Initialize as null

        if (isset($_FILES['item-picture']) && $_FILES['item-picture']['error'] === UPLOAD_ERR_OK) {
            // Validate file size (e.g., max 5MB)
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['item-picture']['size'] > $maxFileSize) {
                throw new Exception("File size is too large. Maximum allowed size is 5MB.");
            }

            // Validate file type (only images allowed)
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['item-picture']['type'], $allowedMimeTypes)) {
                throw new Exception("Only JPEG, PNG, and GIF images are allowed.");
            }

            // Generate a unique file name to prevent conflicts
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/iQamaty_10/public/uploads/";
            $fileExtension = pathinfo($_FILES['item-picture']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid("item_", true) . "." . $fileExtension;
            $filePath = $uploadDirectory . $fileName;

            if (!move_uploaded_file($_FILES['item-picture']['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload the item picture.");
            }

            // Store the web-accessible path in the database
            $itemPicture = '/iQamaty_10/public/uploads/' . $fileName;
        }

        // Insert the lost item into the database
        $sql = "INSERT INTO lost_found (LFName, LFDescription, LFDate, LFLocation, LFStatus, LFPicture)
                VALUES (:itemName, :itemDescription, :itemDate, :itemLocation, :status, :itemPicture)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':itemName' => $itemName,
            ':itemDescription' => $itemDescription,
            ':itemDate' => $itemDate,
            ':itemLocation' => $itemLocation,
            ':status' => $status,
            ':itemPicture' => $itemPicture, // Store the file path if provided
        ]);

        echo json_encode(['success' => true, 'message' => 'Lost item reported successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
