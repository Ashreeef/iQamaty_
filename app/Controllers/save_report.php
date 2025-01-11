<?php

require_once '../../database/db.php';

header("Content-Type: application/json");

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

// Decode JSON payload
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
$requiredFields = ['fullName', 'studentID', 'email', 'phoneNumber', 'roomNumber', 'category', 'description', 'incidentDate', 'urgency'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing field: $field"]);
        exit;
    }
}

try {
    // Start a database transaction
    $pdo->beginTransaction();

    // Prepare SQL query (with backticks around Date and Time since they are reserved)
    $query = "
        INSERT INTO report (FullName, StudentID, Email, PhoneNumber, RoomNumber, Category, Description, `Date`, `Time`, Urgency, FileUploaded)
        VALUES (:fullName, :studentID, :email, :phoneNumber, :roomNumber, :category, :description, :date, :time, :urgency, :fileUploaded)
    ";
    $stmt = $pdo->prepare($query);

    // Handle optional fields
    $incidentTime = $data['incidentTime'] ?? null;

    // Handle file upload (if included as base64-encoded string)
    $fileUploaded = null;
    if (isset($data['fileUploaded']) && !empty($data['fileUploaded'])) {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/iQamaty_10/public/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_report_attachment';
        $filePath = $uploadDir . $fileName;

        if (file_put_contents($filePath, base64_decode($data['fileUploaded'])) === false) {
            throw new Exception('Failed to write the uploaded file.');
        }

        $fileUploaded = '/iQamaty_10/public/uploads/' . $fileName;
    }

    // Execute the query
    $stmt->execute([
        ':fullName' => $data['fullName'],
        ':studentID' => $data['studentID'],
        ':email' => $data['email'],
        ':phoneNumber' => $data['phoneNumber'],
        ':roomNumber' => $data['roomNumber'],
        ':category' => $data['category'],
        ':description' => $data['description'],
        ':date' => $data['incidentDate'],
        ':time' => $incidentTime,
        ':urgency' => $data['urgency'],
        ':fileUploaded' => $fileUploaded,
    ]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(["success" => "Report submitted successfully."]);
} catch (PDOException $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(["error" => "Failed to save report.", "details" => $e->getMessage()]);
    exit;
}
