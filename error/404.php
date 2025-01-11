<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Basic Meta Tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 | iQamaty</title>

    <!-- FontAwesome & (Optional) Global Styles -->
    <script
      src="https://kit.fontawesome.com/15768e4427.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="/iQamaty_10/public/css/styles.css" />
    <link rel="icon" type="image/x-icon" href="/iQamaty_10/public/images/iQamatyVierge.png">

    <!-- Inline CSS: Minimal, on-brand 404 page -->
    <style>
      /* 
        ==========================
        BRAND COLOR VARIABLES
        (Adjust if already in styles.css)
        ==========================
      */
      :root {
        --primary-color: #f2fcfc;
        --secondary-color: #8fbaf3;
        --tertiary-color: #074eb2;
        --text-dark: #074eb2;
        --text-light: #2d4f7c;
        --white: #ffffff;
        --header-font: "Poppins", sans-serif;
      }

      /* 
        ==========================
        GLOBAL & BODY
      */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: var(--header-font), sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background: linear-gradient(
          135deg,
          var(--tertiary-color),
          var(--secondary-color)
        );
        color: var(--white);
        text-align: center;
        margin: 0;
      }

      /* 
        ==========================
        404 CONTAINER
      */
      .error-container {
        background-color: var(--white);
        color: var(--text-dark);
        padding: 2rem;
        width: 90%;
        max-width: 450px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.8s ease-out forwards;
      }
      @keyframes fadeIn {
        0% {
          opacity: 0;
          transform: translateY(10px);
        }
        100% {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* Icon animation */
      .error-icon {
        font-size: 5rem;
        color: var(--secondary-color);
        animation: bounce 1.5s infinite;
        margin-bottom: 1rem;
      }
      @keyframes bounce {
        0%,
        100% {
          transform: translateY(0);
        }
        50% {
          transform: translateY(-15px);
        }
      }

      .error-title {
        font-size: 3rem;
        font-weight: 700;
        color: var(--tertiary-color);
        margin-bottom: 1rem;
      }
      .error-message {
        font-size: 1.1rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
      }

      /* 
        ==========================
        ACTION BUTTONS
      */
      .error-actions a {
        display: inline-block;
        margin: 0.5rem;
        padding: 0.75rem 1.25rem;
        background-color: var(--tertiary-color);
        color: var(--white);
        text-decoration: none;
        border-radius: 5px;
        font-size: 1rem;
        font-weight: 600;
        transition: background-color 0.3s ease, transform 0.3s ease;
      }
      .error-actions a:hover {
        background-color: var(--secondary-color);
        transform: scale(1.05);
      }

      /* 
        ==========================
        MEDIA QUERIES
      */
      @media (max-width: 768px) {
        .error-icon {
          font-size: 3.5rem;
        }
        .error-title {
          font-size: 2.2rem;
        }
        .error-message {
          font-size: 1rem;
        }
        .error-actions a {
          font-size: 0.9rem;
          padding: 0.5rem 1rem;
        }
      }
    </style>
  </head>

  <body>
    <!-- 404 ERROR CONTAINER -->
    <div class="error-container">
      <!-- Bouncing Icon -->
      <div class="error-icon">
        <i class="fa-solid fa-ban"></i>
      </div>
      <!-- Title -->
      <h1 class="error-title">404</h1>
      <!-- Message -->
      <p class="error-message">
        We can’t seem to find the page you’re looking for. Let’s get you back on track!
      </p>
      <!-- Action Buttons -->
      <div class="error-actions">
        <a href="/iQamaty_10/public/index.php">iQamaty Home</a>
        <a href="/iQamaty_10/views/user/faq.php">View FAQ</a>
        <a href="javascript:history.back()">Go Back</a>
      </div>
    </div>
  </body>
</html>
