document.addEventListener("DOMContentLoaded", function () {
    const sign_in_btn = document.querySelector("#sign-in-btn");
    const sign_up_btn = document.querySelector("#sign-up-btn");
    const container = document.querySelector(".container");
    const errorDiv = document.createElement("div"); 

    // Toggle between Sign-In and Sign-Up forms
    sign_up_btn.addEventListener("click", () => {
        container.classList.add("sign-up-mode");
    });

    sign_in_btn.addEventListener("click", () => {
        container.classList.remove("sign-up-mode");
    });

    // Google Sign-In Configuration
    const clientId = '458337814421-9omg7i4ohgdja0a275iun0ae90609839.apps.googleusercontent.com';

    // Initialize Google Sign-In
    google.accounts.id.initialize({
        client_id: clientId,
        callback: handleCredentialResponse
    });

    // Render the Google Sign-In buttons
    google.accounts.id.renderButton(
        document.getElementById("google-sign-up"),
        { theme: "outline", size: "large" }
    );

    google.accounts.id.renderButton(
        document.getElementById("google-sign-in"),
        { theme: "outline", size: "large" }
    );

    // Handle the Google response
    function handleCredentialResponse(response) {
        try {
            const data = jwt_decode(response.credential);
    
            // Restrict to specific domains
            const emailDomain = data.email.split('@')[1];
            if (emailDomain !== "ensia.edu.dz" && emailDomain !== "nhsm.edu.dz") {
                showErrorMessage("Please use your school email (ensia.edu.dz or nhsm.edu.dz) to register or log in.");
                return;
            }
    
            // Check if the user is already registered
            fetch(`/auth/google-callback.php?email=${encodeURIComponent(data.email)}`)
                .then(res => res.json())
                .then(result => {
                    if (result.status === "registered") {
                        // Redirect to feed if registered
                        window.location.href = '/iQamaty_10/views/user/feed.php';
                    } else {
                        // Redirect to registration page if not registered
                        window.location.href = `iQamaty_10/views/auth/registration.php?email=${encodeURIComponent(data.email)}`;
                    }
                })
                .catch(error => {
                    console.error("Error during Google Sign-In process:", error);
                    showErrorMessage("An error occurred. Please try again.");
                });
    
        } catch (error) {
            console.error("Error decoding JWT:", error);
            showErrorMessage("An error occurred during authentication. Please try again.");
        }
    }
    

    // Function to show error message
    function showErrorMessage(message) {
        errorDiv.textContent = message;
        errorDiv.classList.add("error-message");
        const formContainer = document.querySelector(".signin-signup");
        formContainer.insertAdjacentElement("beforeend", errorDiv);  // Insert error message at the bottom of the form
    }
});

// This is the Show/Hide Password function (simple toggle between two input types and icons)
const showPassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("password");
showPassword.addEventListener("click", function() {
    this.querySelector("i").classList.toggle("fa-eye-slash");

    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
});

function fixRecaptchaPosition() {
    const recaptchaModal = document.querySelector('body > div[style*="position: absolute;"]');
    if (recaptchaModal) {
      recaptchaModal.style.left = '50%';
      recaptchaModal.style.transform = 'translateX(-50%)';
    }
  }

document.addEventListener('DOMContentLoaded', fixRecaptchaPosition);
window.addEventListener('resize', fixRecaptchaPosition);
