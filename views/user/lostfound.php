<?php
// Start the session
session_start();
include('../auth/functions.php');

if (!isUserLoggedIn()) {
  header("Location: /iQamaty_10/views/auth/auth.php");
  exit();
}

// Optionally validate the session for added security
validateSession();

// // IT'S WORKING FOR ME BUT EACH ONE HAS A LOCALHOST SO WE SHOULD DEPLOY IT BEFORE RUNNING THIS CODE
// // // Enforce HTTPS and secure session cookies
// // ini_set('session.cookie_secure', '1');
// // ini_set('session.cookie_httponly', '1');
// // ini_set('session.cookie_samesite', 'Strict');

// // Session timeout and activity check
// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
//     session_unset();
//     session_destroy();
//     header("Location: /iQamaty_10/views/auth/auth.php");
//     exit();
// }
// $_SESSION['LAST_ACTIVITY'] = time();

// // Validate session data
// if (!isset($_SESSION['IP'], $_SESSION['UA'])) {
//     session_unset();
//     session_destroy();
//     header("Location: /iQamaty_10/views/auth/auth.php");
//     exit();
// }
// if ($_SESSION['IP'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['UA'] !== $_SERVER['HTTP_USER_AGENT']) {
//     session_unset();
//     session_destroy();
//     header("Location: /iQamaty_10/views/auth/auth.php");
//     exit();
// }

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: /iQamaty_10/views/auth/auth.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Lost or found an item in the dormitory? Check our Lost and Found page to reunite items with their rightful owners.">
    <meta name="keywords" content="lost items, found items, dormitory lost and found, iQamaty, residence items, student lost and found, iQamaty">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/lostfound.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <title>iQamaty - Lost/Found</title>
  </head>
  <body>
    <!-- Navbar -->
    <?php include '../partials/navbar.php'; ?>

    <main class="content">
      <section class="events-section">
        <h2 class="section-title">Lost/Found</h2>

        <!-- Lost/Found boxes will be injected here from JS -->
        <div class="events-boxes" id="events-container"></div>
      </section>

      <!-- Modal for displaying item details -->
      <div id="event-modal" class="modal">
        <div class="modal-content">
          <span class="close-btn" id="close-modal">&times;</span>
          <h2 id="modal-title"></h2>
          <p id="modal-date"></p>
          <p id="modal-location"></p>
          <p id="modal-description"></p>
          <!-- Optional: Add more details or actions here -->
        </div>
      </div>
    </main>

    <?php include '../partials/footer.php'; ?>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="/iQamaty_10/public/js/lostfound.js"></script>
  </body>
</html>
