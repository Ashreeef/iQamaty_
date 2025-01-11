
<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Input validation and sanitization
        $sportName = isset($_POST['sport-name']) ? htmlspecialchars(trim($_POST['sport-name'])) : null;
        $sportLocation = isset($_POST['sport-location']) ? htmlspecialchars(trim($_POST['sport-location'])) : null;
        $sportDescription = isset($_POST['sport-description']) ? htmlspecialchars(trim($_POST['sport-description'])) : null;
        $sportRegister = isset($_POST['sport-register']) ? 1 : 0; // Checkbox value (1 if checked, 0 otherwise)
        $sportFormLink = isset($_POST['sport-link']) ? htmlspecialchars(trim($_POST['sport-link'])) : null;

        // Check if required fields are provided
        if (empty($sportName) || empty($sportLocation) || empty($sportDescription)) {
            throw new Exception("All required fields (name, location, description) must be filled.");
        }

        // Optional registration link (validate URL format if provided)
        if ($sportFormLink && !filter_var($sportFormLink, FILTER_VALIDATE_URL)) {
            throw new Exception("The sport link must be a valid URL.");
        }

        // Handle file upload securely
        $sportPicture = null; // Initialize as null

        if (isset($_FILES['sport-picture']) && $_FILES['sport-picture']['error'] === UPLOAD_ERR_OK) {
            // Validate file size (e.g., max 5MB)
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['sport-picture']['size'] > $maxFileSize) {
                throw new Exception("File size is too large. Maximum allowed size is 5MB.");
            }

            // Validate file type (only images allowed)
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['sport-picture']['type'], $allowedMimeTypes)) {
                throw new Exception("Only JPEG, PNG, and GIF images are allowed.");
            }

            // Generate a unique file name to prevent conflicts
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/iQamaty_10/public/uploads/";
            $fileExtension = pathinfo($_FILES['sport-picture']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid("sport_", true) . "." . $fileExtension;
            $filePath = $uploadDirectory . $fileName;

            if (!move_uploaded_file($_FILES['sport-picture']['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload the sport picture.");
            }

            // Store the web-accessible path in the database
            $sportPicture = "/iQamaty_10/public/uploads/" . $fileName;
        }

        // Insert sport into the database
        $sql = "INSERT INTO sport (SName, SLocation, SDescription, isRegister, SFormLink, SPicture) 
                VALUES (:sportName, :sportLocation, :sportDescription, :sportRegister, :sportFormLink, :sportPicture)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':sportName' => $sportName,
            ':sportLocation' => $sportLocation,
            ':sportDescription' => $sportDescription,
            ':sportRegister' => $sportRegister,
            ':sportFormLink' => $sportFormLink,
            ':sportPicture' => $sportPicture, // Store the file path
        ]);

        echo json_encode(['success' => true, 'message' => 'Sport created successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>
