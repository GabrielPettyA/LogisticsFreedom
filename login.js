const url = "../tp2/includes/api/auth-api/auth.php";

const email = document.getElementById("email");
const emailErr = document.getElementById("emailErr");
const password = document.getElementById("password");
const passwordErr = document.getElementById("passwordErr");
const btnLogin = document.getElementById("btnLogin");
let validForm = [false, false];


btnLogin.addEventListener("click", () => {

    loguearse();

})

function loguearse() {

    const isValid = validForm.filter(element => element == true);
    if(isValid.length == 2){

    loginForm = {};
    loginForm.email = email.value;
    loginForm.password = password.value;

    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(loginForm),
    };

    fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            if (result == "TRUE") {
                return navegarAlHome()
            }
            return alert("Verifique sus credenciales");
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }else{
        alert("Ha ocurrido un error.")
    }

}

function navegarAlHome() {
    window.location.href = "http://localhost/tp2/inicio/";
}

function validarEmail() {

    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (regexEmail.test(email.value)) {

        validForm[0] = true;
        email.className = "form-control is-valid";
        emailErr.style.display = "none";

    } else {

        validForm[0] = false;
        email.className = "form-control is-invalid";
        emailErr.style.display = "block";

    }

    validarForm();

}

function validarPassword() {

    let valor = password.value;

    if (typeof valor == "string" && valor.length > 7 && valor.length <= 20) {

        validForm[1] = true;
        password.className = "form-control is-valid";
        passwordErr.style.display = "none";

    } else {

        validForm[1] = false;
        password.className = "form-control is-invalid";
        passwordErr.style.display = "block";

    }

    validarForm();

}

function validarForm(){

    const isValid = validForm.filter(element => element == true);
    if (isValid.length == 2) {
        btnLogin.disabled = false;
    } else {
        btnLogin.disabled = true;
    }
}
