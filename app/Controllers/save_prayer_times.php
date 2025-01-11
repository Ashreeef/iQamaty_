<?php

require_once '../../database/db.php';

date_default_timezone_set('Africa/Algiers');

header("Content-Type: application/json");

// Only accept POST requests (for example cant just paste the url and get the json as a response)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed"]);
    exit;
}

// Decode JSON payload
$input = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($input['prayerTimes']) || !is_array($input['prayerTimes'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$responseMessages = [];
$pdo->beginTransaction();

try {
    foreach ($input['prayerTimes'] as $date => $times) {
        // Validate each prayer time entry
        if (
            !isset($times['day_of_week']) ||
            !isset($times['fajr']) ||
            !isset($times['dhuhr']) ||
            !isset($times['asr']) ||
            !isset($times['maghrib']) ||
            !isset($times['isha'])
        ) {
            throw new Exception("Incomplete prayer times for date: {$date}");
        }

        $stmt = $pdo->prepare("
            INSERT INTO prayer_times (day_of_week, date, fajr, dhuhr, asr, maghrib, isha, is_overridden, created_at, updated_at)
            VALUES (:day_of_week, :date, :fajr, :dhuhr, :asr, :maghrib, :isha, 1, NOW(), NOW())
            ON DUPLICATE KEY UPDATE
                fajr = VALUES(fajr),
                dhuhr = VALUES(dhuhr),
                asr = VALUES(asr),
                maghrib = VALUES(maghrib),
                isha = VALUES(isha),
                is_overridden = 1,
                updated_at = NOW()
        ");

        $stmt->execute([
            ':day_of_week' => $times['day_of_week'],
            ':date' => $date,
            ':fajr' => $times['fajr'],
            ':dhuhr' => $times['dhuhr'],
            ':asr' => $times['asr'],
            ':maghrib' => $times['maghrib'],
            ':isha' => $times['isha']
        ]);

        $responseMessages[] = "{$times['day_of_week']} prayer times saved successfully.";
    }

    // Commit the transaction
    $pdo->commit();
    echo json_encode(["success" => $responseMessages]);
} catch (Exception $e) {
    // Rollback the transaction on error
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to save prayer times.",
        "details" => $e->getMessage(),
    ]);
    exit;
}
