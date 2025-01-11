const showPassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("Password");

showPassword.addEventListener("click", function() {
    // Toggle the "fa-eye-slash" class to switch between eye and eye-slash icon
    this.querySelector("i").classList.toggle("fa-eye-slash");

    // Toggle input field type between password and text
    const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);
});
