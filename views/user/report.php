<?php
// Start the session
session_start();
include('../auth/functions.php');

if (!isUserLoggedIn()) {
  header("Location: /iQamaty_10/views/auth/auth.php");
  exit();
}

validateSession();

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // Generate a unique token
}



require '../../vendor/autoload.php';

use Valitron\Validator;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode([
        'success' => false,
        'message' => 'CSRF token validation failed.'
    ]);
    exit();
}
    // Ensure values are safely retrieved from the POST array
    $data = [
        'fullName' => isset($_POST['fullName']) ? $_POST['fullName'] : '',
        'email' => isset($_POST['email']) ? $_POST['email'] : '',
        'phoneNumber' => isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '',
        'studentID' => isset($_POST['studentID']) ? $_POST['studentID'] : '',
        'roomNumber' => isset($_POST['roomNumber']) ? $_POST['roomNumber'] : '',
        'category' => isset($_POST['category']) ? $_POST['category'] : '',
        'description' => isset($_POST['description']) ? $_POST['description'] : '',
        'incidentDate' => isset($_POST['incidentDate']) ? $_POST['incidentDate'] : '',
        'urgency' => isset($_POST['urgency']) ? $_POST['urgency'] : ''
    ];

    $v = new Validator($data);

    $v->rules([
        'required' => ['fullName', 'email', 'phoneNumber', 'studentID', 'roomNumber', 'category', 'description', 'incidentDate', 'urgency'],
        'regex' => [
            ['fullName', '/^[\p{L}\s]+$/u'],
            ['email', '/^[a-zA-Z0-9._-]+@(ensia\.edu\.dz|nhsm\.edu\.dz)$/'],
            ['phoneNumber', '/^(05|06|07)\d{8}$/'],
            ['studentID', '/^\d{12}$/'],
            ['roomNumber', '/^[AaBbCcDdEe]{1}(?:[Rr]|\d)\s?[- ]\d{2}$/']
        ]
    ]);

    if ($v->validate()) {
        echo "Report submitted successfully.";
    } else {
        echo "<ul>";
        foreach ($v->errors() as $field => $errors) {
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
        }
        echo "</ul>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Submit issues or report concerns related to dormitory life at iQamaty. Our team is here to ensure a safe and comfortable environment for all residents.">
    <meta name="keywords" content="report issues, student support, dormitory maintenance, safety, iQamaty support, residence reporting, iQamaty">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/report.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <title>iQamaty - Report an Issue</title>
  </head>
  <body>
  <?php include '../partials/navbar.php'; ?>

    <header class="section__container header__container">
      <div class="header__content">
        <h2 class="title">Report an Issue</h2>
        <p class="description">
          Having a problem in the dorm? Let us know, and we will handle it for you!
          Please fill out the form below, and our team will get back to you shortly.
        </p>
      </div>
    </header>

    <section class="section__container report__form__container">
      <form id="report-form" class="form report__form" method="POST">
        <p class="form-title">Report Form</p>

        <div class="flex">
          <label class="input-wrapper" for="full-name">
            <input id="full-name" name="fullName" required placeholder=" " type="text" class="input" />
            <span>Full Name</span>
          </label>

          <label class="input-wrapper" for="student-id">
            <input id="student-id" name="studentID" required placeholder=" " type="text" class="input" />
            <span>Student ID</span>
          </label>
        </div>

        <label class="input-wrapper" for="email">
          <input id="email" name="email" required placeholder=" " type="text" class="input" />
          <span>School Email</span>
        </label>

        <label class="input-wrapper" for="phone-number">
          <input id="phone-number" name="phoneNumber" required placeholder=" " type="tel" class="input" />
          <span>Phone Number</span>
        </label>

        <label class="input-wrapper" for="room-number">
          <input id="room-number" name="roomNumber" required placeholder=" " type="text" class="input" />
          <span>Room Number (eg, A1 32 or A1-32)</span>
        </label>

        <label class="input-wrapper" for="issue-category">
          <select id="issue-category" name="category" required class="input">
            <option value="" disabled selected hidden></option>
            <option value="maintenance">Maintenance</option>
            <option value="cleanliness">Cleanliness</option>
            <option value="noise">Noise</option>
            <option value="safety/security">Safety/Security</option>
            <option value="internet">Internet</option>
            <option value="lost/found">Lost/Found</option>
            <option value="other">Other</option>
          </select>
          <span>Category of Issue</span>
        </label>

        <label class="input-wrapper" for="description">
          <textarea id="description" name="description" required placeholder=" " class="input" rows="4"></textarea>
          <span>Description of Problem</span>
        </label>

        <div class="flex">
          <label class="input-wrapper" for="incident-date">
            <input id="incident-date" name="incidentDate" required type="date" class="input" />
            <span>Date of Incident</span>
          </label>

          <label class="input-wrapper" for="incident-time">
            <input id="incident-time" name="incidentTime" type="time" class="input" />
            <span>Time of Incident</span>
          </label>
        </div>

        <label class="input-wrapper" for="urgency-level">
          <select id="urgency-level" name="urgency" required class="input">
            <option disabled selected></option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
          <span>Urgency Level</span>
        </label>

        <!-- Custom File Upload -->
        <label class="input-wrapper">
          <input type="file" id="file-upload" name="fileUploaded" class="input" accept="image/*,video/*" />
          <label for="file-upload" class="custom-file-upload">
            <i class="ri-upload-line"></i> Upload Attachment (Optional)
          </label>
          <span class="file-name">No file chosen</span>
        </label>

        <button class="submit" type="submit">Submit Report</button>
      </form>
    </section>

    <?php include '../partials/footer.php'; ?>

    <!-- JavaScript for Asynchronous Form Display -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/iQamaty_10/public/js/report.js"></script>
  </body>
</html>
