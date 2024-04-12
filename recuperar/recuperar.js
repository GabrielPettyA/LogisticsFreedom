const url = "../includes/api/auth-api/recuperar.php";

const email = document.getElementById("email");
const emailErr = document.getElementById("emailErr");
const btnRecuperar = document.getElementById("btnRecuperar");


function validarEmail() {

    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (regexEmail.test(email.value)) {

        email.className = "form-control is-valid";
        emailErr.style.display = "none";
        btnRecuperar.disabled = false;

    } else {

        email.className = "form-control is-invalid";
        emailErr.style.display = "block";
        btnRecuperar.disabled = true;

    }

}

function recuperarAcceso() {
    btnRecuperar.disabled = true;
    var data = {
        email: email.value
    };

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    }).then(() => {
        email.className = "form-control";
        email.value = "";
        emailErr.style.display = "none";
        btnRecuperar.disabled = false;
        alert("Revise su casilla de email.");
        window.location.href = "http://localhost/tp2/";
    })

}