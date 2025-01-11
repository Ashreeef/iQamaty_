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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode([
            'success' => false,
            'message' => 'CSRF token validation failed.'
        ]);
        exit();
    }
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
    <meta charset="UTF-8">
    <div class="sidebar"></div>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore the dining options available at dorms, including menu details, dining hours, and meal plans for residents.">
    <meta name="keywords" content="restaurant, dining, dormitory meals, student restaurant, iQamaty food, residence dining options, iQamaty">
    <title>iQamaty - Restoration</title>
    <link rel="stylesheet" href="/iQamaty_10/public/css/restaurant.css">
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
</head>
<body>

    <?php include '../partials/navbar.php'; ?>

    <header class="header">
        <h1>Menu</h1>
    </header>

    <nav class="days-navbar">
        <ul>
            <li data-day="Saturday">Saturday</li>
            <li data-day="Sunday">Sunday</li>
            <li data-day="Monday">Monday</li>
            <li data-day="Tuesday">Tuesday</li>
            <li data-day="Wednesday">Wednesday</li>
            <li data-day="Thursday">Thursday</li>
            <li data-day="Friday">Friday</li>
        </ul>
    </nav>

    <div class="content">
        <div class="menu-border">
            <div class="menu-nav">
                <button class="nav-btn" id="prev-btn">Prev</button>
                <h2 class="meal-header">Breakfast</h2>
                <button class="nav-btn" id="next-btn">Next</button>
            </div>
            

            <div class="meal-content">
                <p><strong>Main Dish:</strong> Pancakes with Syrup</p>
                <p><strong>Secondary Dish:</strong> Scrambled Eggs</p>
                <p><strong>Dessert:</strong> Fresh Fruit Salad</p>
            </div>

            <button onclick="openReport()" class="report-btn" id="report-meal-btn">Report Meal</button>
        </div>
    </div>

    <?php include '../partials/footer.php'; ?>


    <!-- Start Of Meal Report Form-->
    <div class="report-overlay" id="report-overlay">
        <form class="report-form">
            <h2>Report The Meal</h2>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!-- CSRF Token -->
            <label>Enter Your ID:</label>
            <input type="number" class="id-input">
            <label for="description">Description:</label>
            <textarea id="description" rows="4" placeholder="What's the issue?" required></textarea>

            <label class="input-wrapper">
              <input type="file" id="file-upload" class="input" accept="image/*,video/*" />
              <label for="file-upload" class="custom-file-upload">
                <i class="ri-upload-line"></i> Upload Attachment (Optional)
              </label>
            </label>
            
            <button id="submit-report" class="submit-btn">Submit</button>
            <button onclick="closeReport()" id="close-report" class="close-btn">Close</button>
        </form>
    </div>
    <!-- End Of Meal Report Form-->

    <script src="/iQamaty_10/public/js/restaurant.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--To include SweetAlert2 library-->
</body>
</html>
