<?php
session_start();
include('../auth/functions.php');

if (isset($_SESSION['user_id'])) {
    header('Location: /iQamaty_10/views/user/feed.php');
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // Generate a unique token
}

// Secret Key from Google reCAPTCHA
$secretKey = '6Lcg-pkqAAAAANlcznEV5xUZNposjVnY8sWCRI93';

// Verify reCAPTCHA response and CRSF token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF Token Validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode([
            'success' => false,
            'message' => 'CSRF token validation failed.'
        ]);
        exit();
    }

    // Verify reCAPTCHA response
    if (isset($_POST['g-recaptcha-response'])) {
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        // Send request to Google to verify the reCAPTCHA response
        $verifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($verifyUrl . '?secret=' . $secretKey . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if ($responseKeys['success']) {
            // reCAPTCHA is valid, proceed with form processing

            // Process form data (e.g., saving data to database)
            echo "reCAPTCHA validated successfully. Proceeding with form submission.";

        } else {
            // Invalid reCAPTCHA, show an error message
            echo json_encode([
                'success' => false,
                'message' => 'reCAPTCHA verification failed. Please try again.'
            ]);
        }
    } else {
        // reCAPTCHA response missing
        echo json_encode([
            'success' => false,
            'message' => 'Please complete the reCAPTCHA.'
        ]);
    }

    // If login credentials are provided, validate the user
    if (isset($_POST['email'], $_POST['password'])) {
        if (loginUser($pdo, $_POST['email'], $_POST['password'])) {
            echo json_encode([
                'success' => true,
                'message' => 'Login successful.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid login credentials.'
            ]);
        }
        exit();
    }
}

// ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login or register to access your dormitory services. Secure authentication for students and staff." />
    <meta name="keywords" content="login, authentication, register, student login, staff login, secure access, iQamaty" />
    <script src="https://kit.fontawesome.com/15768e4427.js" crossorigin="anonymous"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/iQamaty_10/public/css/auth.css">
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">
    <title>iQamaty - Sign in & Sign up</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Sign In Form -->
                <form method="POST" class="sign-in-form">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="email" name="email" placeholder="School Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Password" required />
                        <button type="button" id="toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                     <!-- CSRF Token -->
                     <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>" />

                    <input type="submit" value="Login" class="btn solid" />
                    <!-- I SHOULD REMEMBER THE USER -->
                    <div class="recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="6Lcg-pkqAAAAACVULLcTo2hPIf8evDFvyAt46Xjv"></div>
                    </div>

                </form>

                <!-- Sign Up Form -->
                <form action="registration.php?action=register" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <button class="btn u" id="sign-in-btn">Register</button>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>Complete the registration form to join iQamaty.</p>
                    <button class="btn transparent" id="sign-up-btn">Sign up</button>
                </div>
                <img src="/iQamaty_10/public/images/logo.svg" class="image" alt="Sign up illustration" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us?</h3>
                    <p>Already have an account? Sign in here.</p>
                    <button class="btn transparent" id="sign-in-btn">Sign in</button>
                </div>
                <img src="/iQamaty_10/public/images/register.svg" class="image" alt="Sign in illustration" />
            </div>
        </div>
    </div>

    <script src="/iQamaty_10/public/js/auth.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
