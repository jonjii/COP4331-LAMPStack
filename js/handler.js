const urlBase = "http://COP4331-5.com/api/";

function handleLogin() {
    const username = document.querySelector("loginName").value;
    const password = document.querySelector("loginPassword").value;

    const err = logIn(username, password);
    if (err != null) {
        document.querySelector("#login-result").innerHTML =
            "Invalid username or password";
        console.log(err);
        return;
    }

    window.location.href = "contacts.html";
}

function handleAddContact() {
    document.getElementById("info").classList.toggle("info-selected");
}

// Registers a user into the database, then logs them in
function handleRegister() {
    const firstName = document.querySelector("#register-first-name").value;
    const lastName = document.querySelector("#register-last-name").value;
    const username = document.querySelector("#register-username").value;
    const password = document.querySelector("#register-password").value;
    const confirmPassword = document.querySelector(
        "#register-confirm-password"
    ).value;

    // Check matching password
    if (password != confirmPassword) {
        document.querySelector("#register-result").innerHTML =
            "Mismatched password";
        return;
    }
    // Check min pass length
    if (password.length < 8) {
        document.querySelector("#register-result").innerHTML =
            "Invalid password. Password must be at least 8 characters long.";
        return;
    }
    document.querySelector("#register-result").innerHTML = "";

    // Register user
    const err = registerUser(firstName, lastName, username, password);
    if (err != null) {
        console.log(err);
        return;
    }

    window.location.href = "contacts.html";
}
