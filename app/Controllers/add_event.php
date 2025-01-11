<?php
require_once '../../database/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Input validation and sanitization
        $eventName = isset($_POST['event-name']) ? htmlspecialchars(trim($_POST['event-name'])) : null;
        $eventLocation = isset($_POST['event-location']) ? htmlspecialchars(trim($_POST['event-location'])) : null;
        $eventDetails = isset($_POST['event-description']) ? htmlspecialchars(trim($_POST['event-description'])) : null;
        $eventDate = isset($_POST['event-date']) ? trim($_POST['event-date']) : null;
        $eventFormLink = isset($_POST['event-link']) ? htmlspecialchars(trim($_POST['event-link'])) : null;

        // Check if required fields are provided
        if (empty($eventName) || empty($eventLocation) || empty($eventDetails) || empty($eventDate)) {
            throw new Exception("All required fields (name, location, description, date) must be filled.");
        }

        // Validate event date format (YYYY-MM-DD)
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $eventDate)) {
            throw new Exception("Invalid event date format. Please use YYYY-MM-DD.");
        }

        // Optional registration link (validate URL format if provided)
        if ($eventFormLink && !filter_var($eventFormLink, FILTER_VALIDATE_URL)) {
            throw new Exception("The event link must be a valid URL.");
        }

        // Handle file upload securely
        $eventPicture = null; // Initialize as null

        if (isset($_FILES['event-picture']) && $_FILES['event-picture']['error'] === UPLOAD_ERR_OK) {
            // Validate file size (e.g., max 5MB)
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES['event-picture']['size'] > $maxFileSize) {
                throw new Exception("File size is too large. Maximum allowed size is 5MB.");
            }

            // Validate file type (only images allowed)
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($_FILES['event-picture']['type'], $allowedMimeTypes)) {
                throw new Exception("Only JPEG, PNG, and GIF images are allowed.");
            }

            // Generate a unique file name to prevent conflicts
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/iQamaty_10/public/uploads/";
            $fileExtension = pathinfo($_FILES['event-picture']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid("event_", true) . "." . $fileExtension;
            $filePath = $uploadDirectory . $fileName;

            if (!move_uploaded_file($_FILES['event-picture']['tmp_name'], $filePath)) {
                throw new Exception("Failed to upload the event picture.");
            }

            // Store the web-accessible path in the database
            $eventPicture = "/iQamaty_10/public/uploads/" . $fileName;
        }

        // Insert event into the database
        $sql = "INSERT INTO event (EventName, EventDate, EventLocation, EventDetails, EventFormLink, isRegister, EventPicture) 
                VALUES (:eventName, :eventDate, :eventLocation, :eventDetails, :eventFormLink, :isRegister, :eventPicture)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':eventName' => $eventName,
            ':eventDate' => $eventDate,
            ':eventLocation' => $eventLocation,
            ':eventDetails' => $eventDetails,
            ':eventFormLink' => $eventFormLink,
            ':isRegister' => $eventFormLink ? 1 : 0, // Enable registration if a link is provided
            ':eventPicture' => $eventPicture, // Store the file path
        ]);

        echo json_encode(['success' => true, 'message' => 'Event created successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>
