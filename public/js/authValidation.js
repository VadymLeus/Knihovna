function validateLoginForm() {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if (email.trim() === "") {
        alert("Please enter your email.");
        return false;
    }

    if (password.trim() === "") {
        alert("Please enter your password.");
        return false;
    }

    return true;
}
