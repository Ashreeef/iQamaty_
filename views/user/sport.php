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
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Engage in a range of sports activities at iQamaty. Join football, volleyball, handball, and basketball tournaments, and stay active within the residence community!">
  <meta name="keywords" content="sports, university sports, tournaments, student activities, football, volleyball, handball, basketball, iQamaty">
  <link rel="stylesheet" href="/iQamaty_10/public/css/sport.css">
  <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css">
  <link rel="stylesheet" href="/iQamaty_10/public/css/sportCards.css">
  <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

  <title>iQamaty - Sports</title>
</head>

<body>

  <?php include '../partials/navbar.php'; ?>



  <header>
    <h1>Sports</h1>
    <div class="join-book">
      <ul>
        <li id="joinBtn" onclick="JoinPage()">Join Teams</li>
        <li id="bookBtn" onclick="BookPage()">Book the Stadium</li>
      </ul>
    </div>
  </header>


  <main id="joinContent" class="content">
    <section class="sports-section">


      <!-- sport boxes will be injected here from JS -->
      <div class="sports-boxes" id="sports-container"></div>
    </section>

    <!-- sport Modal for displaying details -->
    <div id="sport-modal" class="modal">
      <div class="modal-content">
        <span class="close-btn" id="close-modal">&times;</span>
        <h2 id="modal-title"></h2>
        <p id="modal-date"></p>
        <p id="modal-location"></p>
        <p id="modal-description"></p>
        <button id="register-btn" class="register-btn" style="display: none;">
          <span>Register</span>
        </button>
      </div>
    </div>
  </main>

  <div id="bookContent" class="tab-content hide">
    <h2>Timetable</h2>
    <p>Free Slots:</p>
    <ul id="timetable">
      <!-- fetched from the database -->
    </ul>
    <button onclick="openBookingForm()">Book</button>
  </div>


  <?php include '../partials/footer.php'; ?>


  <!-- Booking Modal -->
  <div class="modal-overlay" id="modal-overlay">
    <!-- I used get because the data is not to much sensitive -->
    <form class="modal2" id="bookingModal" action="#" method="get">
      <h2>Book for a game</h2>
      <label for="timeSelect">Select a time:</label>
      <select id="timeSelect">
        <!-- fetched from the database -->
      </select>
      <br>
      <input type="text" id="playerIds" placeholder="Enter IDs of other players" />
      <span id="errorMessage" class="error-message"></span>
      <br>
      <div class="buttons">
        <button onclick="submitBooking()" id="booked">Submit</button>
        <button onclick="closeBookingModal()">Close</button>
      </div>
    </form>
  </div>

  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--To include SweetAlert2 library-->
  <script src="/iQamaty_10/public/js/sport.js"></script>
</body>

</html>