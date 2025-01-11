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
  <meta name="description" content="Find prayer schedules, and stay connected to your spiritual practice within the residence.">
  <meta name="keywords" content="prayer, prayer schedule, student spirituality, residence prayer room, iQamaty prayer, iQamaty">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
  <link rel="stylesheet" href="/iQamaty_10/public/css/prayertimes.css" />
  <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
  <title>iQamaty - Prayer Times</title>
</head>
<body>
<?php include '../partials/navbar.php'; ?>

  <main class="content">
    <section class="prayer-times">
      <h2 class="mosque-title">Masjid El Tawba, Mahelma 3</h2>

      <div class="clock">
        <h1 id="time">09:14 <span>:58</span></h1>
      </div>

      <div class="date-info">
        <span id="islamic-date">Loading...</span>
        <h3>Today</h3>
        <span id="timezone">Time Zone: UTC+1,</span>
        <span id="gregorian-date">Loading...</span>
      </div>

      <div class="prayer-boxes" id="prayer-times">
        <!-- prayer times will be injected here from JS -->
      </div>
    </section>
  </main>

  <?php include '../partials/footer.php'; ?>

  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="/iQamaty_10/public/js/prayertimes.js"></script>
</body>
</html>
