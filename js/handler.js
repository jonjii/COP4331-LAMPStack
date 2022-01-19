const urlBase = "http://COP4331-5.com/api/";

function handleLogin() {
    const username = document.getElementById("loginName").value;
    const password = document.getElementById("loginPassword").value;

    let id = logIn(username, password);
    if (id instanceof Error) {
        document.getElementById("login-result").innerHTML =
            "Invalid username or password";
        return;
    }

    window.location.href = "contacts.html";
}

function handleAddContact() {
    document.getElementById("info").classList.toggle("info-selected");
}