<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once '../../database/db.php';

// Function to fetch all user emails
function fetchUserEmails($pdo) {
    $stmt = $pdo->query("SELECT email FROM user");
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

// Function to fetch the last inserted event details
function fetchLatestEvent($pdo) {
    $stmt = $pdo->query("SELECT EventName, EventDate, EventLocation FROM event ORDER BY EventID DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to send emails
function sendEventEmails($pdo) {
    $userEmails = fetchUserEmails($pdo);

    $event = fetchLatestEvent($pdo);
    if (!$event) {
        error_log("No new event found.");
        return;
    }

    $eventName = htmlspecialchars($event['EventName']);
    $eventDate = htmlspecialchars($event['EventDate']);
    $eventLocation = htmlspecialchars($event['EventLocation']);

    $subject = "New Event: $eventName";
    $body = "
        <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
            <h1 style='color: #333;'>You're Invited!</h1>
            <p><strong>Event Name:</strong> $eventName</p>
            <p><strong>Date:</strong> $eventDate</p>
            <p><strong>Location:</strong> $eventLocation</p>
        </div>
    ";

    foreach ($userEmails as $email) {
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = getenv('SMTP_PORT');

            // Email settings
            $mail->setFrom(getenv('FROM_EMAIL'), 'Event Organizer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            echo "Email sent to: $email<br>";
        } catch (Exception $e) {
            error_log("Failed to send email to $email. Error: {$mail->ErrorInfo}");
        }
    }
}

// Call the function after inserting a new event
sendEventEmails($pdo);
?>
