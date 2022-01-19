const baseURL = "http://";
const extension = "php";

class User {
    constructor(id) {
        this.id = id;
        this.name = "";
        this.password = "";
        this.uid = 0;
        this.dateCreated = null;
        this.dateLastUpdated = null;
    }
}

// method: string, url: string, params: Object
// Returns json response, or error
function doRequest(method, url, params) {
    // Make Request
    let xhr = new XMLHttpRequest();
    xhr.open(method, url);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

    try {
        xhr.onreadystatechange = function () {
            if (xhr.responseText == "") return null;

            const resp = JSON.parse(xhr.responseText);
            if (this.readyState == 4 && this.status == 200) {
                return resp;
            }
            throw new Error(`${this.status}: ${resp.error}`);
        };
        xhr.send(JSON.stringify(params));
    } catch (e) {
        return e;
    }
}

// username: string, password: string
function logIn(username, password) {
    let params = {
        username: username,
        password: md5(password),
    };
    let resp = doRequest("GET", baseURL + "users", params);
    if (!resp) {
        return new Error(resp);
    }

    setCookie(resp.id);
    return resp.id;
}

// id: number
function setCookie(id) {
    const mins = 20;
    const date = new Date(Date.now() + mins * 60 * 1000);
    document.cookie = `id=${id};expires=${date.toUTCString()}`;
}

function getID() {
    const id = document.cookie.split(";").split("=")[1];
    if (!cookie || !cookie.id) {
        return new Error("getID error: invalid cookie");
    }

    return cookie.id;
}

function logout() {
    document.cookie = `id=0;expires=Thu, 01 Jan 1970 00:00:00 GMT`;
    window.location.href = "index.html";
}
