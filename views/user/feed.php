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

// temporary sample data
$user_name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Flenn Fleni';
$user_room = isset($_SESSION['room']) ? $_SESSION['room'] : 'B2-45';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Stay updated with the latest announcements and news from the residency administration.">
    <meta name="keywords" content="feed, announcements, iQamaty, residency, administration, updates">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/feed.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <title>iQamaty - Feed</title>
</head>
<body>
    <?php include '../partials/navbar.php'; ?>

    <main class="content section__container">
        <div class="container">
            <div class="user-info-banner">
                <div class="welcome-message">
                    Welcome, <?php echo htmlspecialchars($user_name); ?>!
                </div>
                <div class="user-details">
                    <p>Room: <?php echo htmlspecialchars($user_room); ?></p>
                </div>
            </div>

            <div class="feed-wrapper">
                <section class="feed-section">
                    <h2 class="section-title"><i class="ri-bell-line"></i> Announcements</h2>
                    <div id="announcements-container">
                        <!-- posts will be injected here from JS -->
                    </div>
                </section>

                <aside class="sidebar">
                    <div class="section-box" id="last-lostfound">
                        <h3 class="sidebar-title">Last Lost/Found</h3>
                        <div class="content" id="last-lostfound-content">
                            <p>Loading last lost/found item...</p>
                        </div>
                        <button onclick="window.location.href='/iQamaty_10/views/user/lostfound.php'">View All Lost/Found</button>
                    </div>

                    <div class="section-box" id="last-event">
                        <h3 class="sidebar-title">Last Event</h3>
                        <div class="content" id="last-event-content">
                            <p>Loading last event...</p>
                        </div>
                        <button onclick="window.location.href='/iQamaty_10/views/user/events.php'">View All Events</button>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <?php include '../partials/footer.php'; ?>

    <script src="/iQamaty_10/public/js/feed.js"></script>
</body>
</html>
