function togglePassword(inputId) {
    var passwordInput = document.getElementById(inputId);
    var passwordToggle = document.querySelector('#' + inputId + ' + .password-toggle');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggle.src = "assets/img/mata.svg";
    } else {
        passwordInput.type = "password";
        passwordToggle.src = "assets/img/mata.svg";
    }
}
