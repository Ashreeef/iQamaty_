<?php
// Start the session
session_start();
include('../auth/functions.php');

// if (!isUserLoggedIn()) {
//     header("Location: /iQamaty_10/views/auth/auth.php");
//     exit();
//   }
  
//   // Optionally validate the session for added security
//   validateSession();

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Find answers to frequently asked questions about dormitory life, policies, and services at iQamaty. Get all the info you need right here!">
    <meta name="keywords" content="FAQ, questions and answers, dormitory information, iQamaty FAQ, residence policies, student guide, iQamaty">
    <title>iQamaty - FAQ</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <link rel="stylesheet" href="/iQamaty_10/public/css/faq.css" />
    <!-- FontAwesome for Arrows -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>
<body>
<?php include '../partials/navbar.php'; ?>


      <header class="section__container header__container">
        <div class="header__content">
            <h1 class="title">FREQUENTLY ASKED QUESTIONS</h1>
            <p class="description">
                Find answers to the most common questions below. If you can't find what you're looking for, feel free to contact us!
            </p>
        </div>
    </header>    

    <section class="faq-section section__container">
        <ul class="faq">
            <li>
                <div class="q">
                    <span class="arrow"><i class="fa fa-chevron-right"></i></span>
                    <span class="question-text">What is iQamaty?</span>
                </div>
                <div class="a">
                    <p>
                        iQamaty is a comprehensive web-based platform designed to streamline dormitory services for university students and administrators.
                        This website will provide students with an easy way to access essential dorm-related services such as announcements, event registration, and maintenance requests.
                        Dorm administrators can efficiently manage dorm operations and communicate with students through the platform.
                    </p>
                </div>
            </li>
            <li>
                <div class="q">
                    <span class="arrow"><i class="fa fa-chevron-right"></i></span>
                    <span class="question-text">How do I create an account on iQamaty?</span>
                </div>
                <div class="a">
                    <p>
                        Please go to <a href="/iQamaty_10/views/auth/auth.html">Sign Up</a> and fill the form to complete your registration.
                    </p>                    
                </div>
            </li>
            <li>
                <div class="q">
                    <span class="arrow"><i class="fa fa-chevron-right"></i></span>
                    <span class="question-text">Are there any fees associated with using iQamaty services?</span>
                </div>
                <div class="a">
                    <p>
                        No, there are not. iQamaty website services are completely free.
                    </p>
                </div>
            </li>
            <li>
                <div class="q">
                    <span class="arrow"><i class="fa fa-chevron-right"></i></span>
                    <span class="question-text">How can I report a maintenance issue in my dorm?</span>
                </div>
                <div class="a">
                    <p>
                        You can report a maintenance issue or any kind of problem concerning your daily life in the residency, by clicking on <a href="/iQamaty_10/views/user/report.php">Report Page</a>.
                    </p>
                </div>
            </li>
            <li>
                <div class="q">
                    <span class="arrow"><i class="fa fa-chevron-right"></i></span>
                    <span class="question-text">What is the Feed used for?</span>
                </div>
                <div class="a">
                    <p>
                        The <a href="/iQamaty_10/views/user/feed.html">Feed</a> is a centralized space for students to view the latest announcements and updates from the dormitory administration.
                        It provides important information such as event notifications and maintenance alerts, helping students stay informed about their dormitory community.
                        Regularly checking the feed ensures that students don't miss out on essential news and opportunities.
                    </p>
                </div>
            </li>
        </ul>
    </section>

    <?php include '../partials/footer.php'; ?>

    <!-- JS for FAQ Toggle -->
    <script>
        const faqItems = document.querySelectorAll('.q');
        faqItems.forEach(item => {
            item.addEventListener('click', function () {
                const answer = this.nextElementSibling;
                const arrowIcon = this.querySelector('.fa');
                arrowIcon.classList.toggle('fa-chevron-right');
                arrowIcon.classList.toggle('fa-chevron-down');
                answer.classList.toggle('a-opened');
            });
        });
    </script>

    <!-- JS for scroll reveal -->
     <script src="https://unpkg.com/scrollreveal"></script>
     <script>
        const scrollRevealOption = {
        distance: "50px",
        origin: "bottom",
        duration: 1000,
        };

        ScrollReveal().reveal(".header__content", {
        ...scrollRevealOption,
        origin: "right",
        });
        ScrollReveal().reveal(".section__container", {
        ...scrollRevealOption,
        delay: 300,
        });
     </script>

     <!--Toggle navbar-->
     <script>
        document.getElementById("menu-btn").addEventListener("click", function() {
        document.getElementById("nav-links").classList.toggle("open");
        });
     </script>
</body>
</html>
