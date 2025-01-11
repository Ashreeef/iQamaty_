<?php

require_once '../../database/db.php';

date_default_timezone_set('Africa/Algiers');

header("Content-Type: application/json");

$city = 'Mahelma';
$country = 'Algeria';
$method = 2;

// Get the start and end dates of the current week (Sunday to Saturday)
$today = new DateTime();
$dayOfWeek = (int)$today->format('w'); // 0 (Sunday) to 6 (Saturday)
$startOfWeek = clone $today;
$startOfWeek->modify("-{$dayOfWeek} days")->setTime(0, 0, 0);
$endOfWeek = clone $startOfWeek;
$endOfWeek->modify("+6 days")->setTime(23, 59, 59);


// Format dates for database queries
$startOfWeekStr = $startOfWeek->format('Y-m-d');
$endOfWeekStr = $endOfWeek->format('Y-m-d');

try {
    // Fetch all overridden prayer times for the current week from the database
    $stmt = $pdo->prepare("
    SELECT date, fajr, dhuhr, asr, maghrib, isha 
    FROM prayer_times 
    WHERE date BETWEEN :startOfWeek AND :endOfWeek AND is_overridden = 1
    ");
    $stmt->execute([
        ':startOfWeek' => $startOfWeekStr,
        ':endOfWeek' => $endOfWeekStr,
    ]);
    $overriddenTimes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Create a map of overridden times keyed by date
    $overriddenMap = [];
    foreach ($overriddenTimes as $time) {
        $overriddenMap[$time['date']] = [
            'Fajr' => $time['fajr'],
            'Dhuhr' => $time['dhuhr'],
            'Asr' => $time['asr'],
            'Maghrib' => $time['maghrib'],
            'Isha' => $time['isha']
        ];
    }

    $prayerTimesWeek = [];

    // Iterate through each day of the week
    for ($i = 0; $i < 7; $i++) {
        // Clone the startOfWeek for each iteration to prevent modification of the original object
        $date = clone $startOfWeek;
        $date->modify("+$i days");
        $dateStr = $date->format('Y-m-d');
        $dayOfWeek = $date->format('l');

        if (isset($overriddenMap[$dateStr])) {
            // Use overridden prayer times from the database
            $prayerTimes = $overriddenMap[$dateStr];
        } else {
            // Fetch prayer times from the Aladhan API for this day
            $apiDate = $date->format('d-m-Y');
            $apiUrl = "https://api.aladhan.com/v1/timingsByCity?city={$city}&country={$country}&method={$method}&date={$apiDate}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Timeout after 10 seconds
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Maximum redirects

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new Exception('cURL error: ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode !== 200) {
                throw new Exception("API request failed with status code {$httpCode}");
            }

            curl_close($ch);

            $data = json_decode($response, true);

            if ($data['code'] !== 200) {
                throw new Exception('API Error: ' . $data['data']['status']);
            }

            $apiTimings = $data['data']['timings'];

            // Format the prayer times
            $prayerTimes = [
                'Fajr' => date('H:i', strtotime($apiTimings['Fajr'])),
                'Dhuhr' => date('H:i', strtotime($apiTimings['Dhuhr'])),
                'Asr' => date('H:i', strtotime($apiTimings['Asr'])),
                'Maghrib' => date('H:i', strtotime($apiTimings['Maghrib'])),
                'Isha' => date('H:i', strtotime($apiTimings['Isha']))
            ];
        }

        $prayerTimesWeek[] = [
            'day_of_week' => $dayOfWeek,
            'date' => $dateStr,
            'fajr' => $prayerTimes['Fajr'],
            'dhuhr' => $prayerTimes['Dhuhr'],
            'asr' => $prayerTimes['Asr'],
            'maghrib' => $prayerTimes['Maghrib'],
            'isha' => $prayerTimes['Isha'],
        ];
    }

    echo json_encode($prayerTimesWeek);
} catch (PDOException $e) {
    // Database-related error
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to fetch prayer times from database.",
        "details" => $e->getMessage(),
    ]);
    exit;
} catch (Exception $e) {
    // Other errors (e.g., API-related)
    http_response_code(500);
    echo json_encode([
        "error" => "Failed to fetch prayer times from API.",
        "details" => $e->getMessage(),
    ]);
    exit;
}
?>
