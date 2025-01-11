<?php
require_once '../../database/db.php';
header('Content-Type: application/json');

try {
    // Check HTTP method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    // Retrieve and sanitize input
    $feedTitle = filter_input(INPUT_POST, 'feed-title', FILTER_SANITIZE_STRING);
    $feedAdmin = filter_input(INPUT_POST, 'feed-admin', FILTER_SANITIZE_STRING);
    $feedDescription = filter_input(INPUT_POST, 'feed-description', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (!$feedTitle || !$feedAdmin || !$feedDescription) {
        throw new Exception("All required fields (title, admin name, description) must be provided.");
    }

    // Check for duplicate feed
    $sql = "SELECT COUNT(*) FROM feed WHERE feed_title = :feedTitle";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':feedTitle' => $feedTitle]);
    $feedCount = $stmt->fetchColumn();

    if ($feedCount > 0) {
        throw new Exception("A feed with this title already exists.");
    }

    // Handle optional file upload
    $feedImage = null;
    if (isset($_FILES['feed-image']) && $_FILES['feed-image']['error'] === UPLOAD_ERR_OK) {
        $feedImage = handleFileUpload($_FILES['feed-image']);
    }

    // Insert new feed into the database
    $sql = "INSERT INTO feed (feed_title, feed_admin, feed_description, feed_image)
            VALUES (:feedTitle, :feedAdmin, :feedDescription, :feedImage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':feedTitle'       => $feedTitle,
        ':feedAdmin'       => $feedAdmin,
        ':feedDescription' => $feedDescription,
        ':feedImage'       => $feedImage,
    ]);

    // Success response
    echo json_encode([
        'success' => true,
        'message' => 'Announcement created successfully.',
    ]);
} catch (Exception $e) {
    // Error response
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
    ]);
}

/**
 * Handle file upload securely.
 *
 * @param array $file
 * @return string|null
 * @throws Exception
 */
function handleFileUpload(array $file)
{
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . "/iQamaty_10/public/uploads/";

    // Ensure directory exists
    if (!is_dir($uploadDirectory) && !mkdir($uploadDirectory, 0755, true)) {
        throw new Exception("Failed to create upload directory.");
    }

    // Validate file size (~5MB max)
    $maxFileSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxFileSize) {
        throw new Exception("File size exceeds the maximum allowed size of 5MB.");
    }

    // Validate file type
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    if (!in_array($mimeType, $allowedMimeTypes)) {
        throw new Exception("Invalid file type. Only JPEG, PNG, and GIF are allowed.");
    }

    // Generate unique file name and move file
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid("feed_", true) . "." . $fileExtension;
    $filePath = $uploadDirectory . $fileName;

    if (!move_uploaded_file($file['tmp_name'], $filePath)) {
        throw new Exception("Failed to upload the file.");
    }

    return "/iQamaty_10/public/uploads/" . $fileName;
}
?>
