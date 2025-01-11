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

// // IT'S WORKING FOR ME BUT EACH ONE HAS A LOCALHOST SO WE SHOULD DEPLOY IT BEFORE RUNNING THIS CODE
// // // Enforce HTTPS and secure session cookies
// // ini_set('session.cookie_secure', '1');
// // ini_set('session.cookie_httponly', '1');
// // ini_set('session.cookie_samesite', 'Strict');
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Discover and register for upcoming events at iQamaty! Stay connected with all activities, celebrations, and community gatherings happening at your university residence." />
  <meta name="keywords" content="events, university residence events, community events, student events, celebrations, iQamaty" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
  <link rel="stylesheet" href="/iQamaty_10/public/css/events.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
  <title>iQamaty - Events</title>
</head>
<body>
<?php include '../partials/navbar.php'; ?>

<main class="content">
  <section class="events-section">
    <h2 class="section-title">Upcoming Events</h2>

    <!-- event boxes will be injected here from JS -->
    <div class="events-boxes" id="events-container"></div>
  </section>

  <!-- Event Modal for displaying details -->
  <div id="event-modal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="close-modal">&times;</span>
      <h2 id="modal-title"></h2>
      <p id="modal-date"></p>
      <p id="modal-location"></p>
      <p id="modal-description"></p>
      <a id="register-btn" class="register-btn" target="_blank" style="display: none;">
        <span>Register</span>
      </a>
    </div>
  </div>
</main>

<?php include '../partials/footer.php'; ?>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--To include SweetAlert2 library-->
<script src="/iQamaty_10/public/js/events.js"></script>
</body>
</html>
