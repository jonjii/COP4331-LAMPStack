const urlBase = "http://COP4331-5.com/api/";

// Logs a user into the database, redirects to contacts page
function handleLogin() {
    const username = document.querySelector("#login-name").value;
    const password = document.querySelector("#login-password").value;

    const err = logIn(username, password);
    if (err != null) {
        document.querySelector("#login-result").innerHTML =
            "Invalid username or password";
        console.log(err);
        return;
    }

    window.location.href = "contacts.html";
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

    // Check all data is filled
    if (firstName.length == 0 || lastName.length == 0 || username.length == 0) {
        document.querySelector("#register-result").innerHTML =
            "Please enter all information.";
        return;
    }
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
        document.querySelector("#register-result").innerHTML =
            "Error: " + err.message;
        return;
    }

    window.location.href = "contacts.html";
}

// Adds a contact, then prepares it for editing
function handleCreateContact() {
    if (document.getElementById("info").classList.contains("info-selected")) {
        return;
    }

    // Open contact tab
    document.getElementById("info").classList.add("info-selected");
    const cid = createContact(getID, "", "", "", "");
}
