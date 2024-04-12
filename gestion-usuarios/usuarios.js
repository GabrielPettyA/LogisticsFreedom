const url = "../includes/api/gestion-usuarios-api/gestion-usuarios.php";

// Dinamica formulario
const selectModType = document.getElementById("selectModType");
const formNewUser = document.getElementById("formNewUser");
const formEditUser = document.getElementById("formEditUser");
const formDelUser = document.getElementById("formDelUser");
const btnNewUser = document.getElementById("btnNewUser");
const btnEditUser = document.getElementById("btnEditUser");
const btnDelUser = document.getElementById("btnDelUser");

// Nuevo usuario
const newUserMail = document.getElementById("newUserMail");
const newUserMailErr = document.getElementById("newUserMailErr");
const newUserPass = document.getElementById("newUserPass");
const newUserPassErr = document.getElementById("newUserPassErr");
const btnCrearUsuario = document.getElementById("btnCrearUsuario");
const textConfirmarUsuario = document.getElementById("textConfirmarUsuario");

// Editar usuario
const selectEditUser = document.getElementById("selectEditUser");
const textConfirmarEditarUsuario = document.getElementById("textConfirmarEditarUsuario");
const btnEditarUsuarioModal = document.getElementById("btnEditarUsuarioModal");
const btnEditarUsuario = document.getElementById("btnEditarUsuario");

// Eliminar usuario
const selectDeleteUser = document.getElementById("selectDeleteUser");
const btnEliminarUsuarioModal = document.getElementById("btnEliminarUsuarioModal");
const textConfirmarEliminarUsuario = document.getElementById("textConfirmarEliminarUsuario");

//Variables
let userData = [];
let validForm = [false, false];

// ----------------------- Funciones generales ------------------

function obtenerDatos() {
    fetch(url + "?usuarios=valor")
        .then(response => response.json())
        .then(data => {
            userData = Array.from(data);
            cargarListaDeUsuarios();
        })
        
}

function cangeForm() {
    switch (selectModType.value) {
        case "C":
            // Form crear usuario
            formNewUser.style.display = "block";
            btnNewUser.style.display = "flex";
            // Form no van
            formEditUser.style.display = "none";
            formDelUser.style.display = "none";
            btnEditUser.style.display = "none";
            btnDelUser.style.display = " none";
            break;
        case "D":
            resetFormNuevoUsuario();
            // Form eliminar usuario
            formDelUser.style.display = "block";
            btnDelUser.style.display = "flex";
            // Form no van
            formEditUser.style.display = "none";
            formNewUser.style.display = "none";
            btnEditUser.style.display = "none";
            btnNewUser.style.display = " none";
            break;
        default:
            resetFormNuevoUsuario();
            // Form editar usuario
            formEditUser.style.display = "block";
            btnEditUser.style.display = "flex";
            // Form no van
            formDelUser.style.display = "none";
            formNewUser.style.display = "none";
            btnDelUser.style.display = "none";
            btnNewUser.style.display = " none";
            break;

    }
}

function cargarListaDeUsuarios(){
    
    selectEditUser.innerHTML = "";
    selectDeleteUser.innerHTML = "";

    const optionDefaultEditar = document.createElement("option");
    const optionDefaultEliminar = document.createElement("option");

    optionDefaultEditar.textContent = "Seleccione usuario a editar";
    optionDefaultEditar.value = "";
    optionDefaultEditar.disabled = true;
    optionDefaultEditar.selected = true;

    optionDefaultEliminar.textContent = "Seleccione usuario a eliminar";
    optionDefaultEliminar.value = "";
    optionDefaultEliminar.disabled = true;
    optionDefaultEliminar.selected = true;

    selectEditUser.appendChild(optionDefaultEditar);
    selectDeleteUser.appendChild(optionDefaultEliminar);
    
    userData.forEach((element)=>{
        
        const optionEditar = document.createElement("option");
        const optionEliminar = document.createElement("option");

        optionEditar.textContent = element.email;
        optionEliminar.textContent = element.email;

        optionEditar.value = element.email + "," + element.id;
        optionEliminar.value = element.email + "," + element.id;

        selectEditUser.appendChild(optionEditar);
        selectDeleteUser.appendChild(optionEliminar);
    })  
}

// ---------------------- Nuevo usuario -----------------------------

function validarEmail() {

    const regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    let email = newUserMail.value;

    var existeMail = userData.some((element) => {
        return element.email === email;
    });

    if (regexEmail.test(email) && !existeMail) {

        validForm[0] = true;
        newUserMail.className = "form-control is-valid";
        newUserMailErr.style.display = "none";

    } else {

        validForm[0] = false;
        newUserMail.className = "form-control is-invalid";
        newUserMailErr.style.display = "block";

    }

    validarForm();

}

function validarPassword() {

    let valor = newUserPass.value;

    if (typeof valor == "string" && valor.length > 7 && valor.length <= 20) {

        validForm[1] = true;
        newUserPass.className = "form-control is-valid";
        newUserPassErr.style.display = "none";

    } else {

        validForm[1] = false;
        newUserPass.className = "form-control is-invalid";
        newUserPassErr.style.display = "block";

    }

    validarForm();

}

function validarForm() {

    const isValid = validForm.filter(element => element == true);
    if (isValid.length == 2) {
        btnCrearUsuario.disabled = false;
    } else {
        btnCrearUsuario.disabled = true;
    }
}

btnCrearUsuario.addEventListener("click", () => {

    const isValid = validForm.filter(element => element == true);
    if (isValid.length == 2) {
        data = formatoNuevoUsuario();
        textConfirmarUsuario.innerHTML = `
        <span style="font-weight:bold;"> Se va a crear un nuevo usuario:</span> <br>
        <span style="font-weight:bold;">• Email:</span> "${data.email}" <br>
        <span style="font-weight:bold;">• Permisos:</span> "${data.roles.join(" - ")}".`;
    }

})



function crearUsuario() {

    const isValid = validForm.filter(element => element == true);
    if (isValid.length == 2) {

        data = formatoNuevoUsuario();

        const requestOptions = {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
        };

        fetch(url, requestOptions)
            .then(response => response.text())
            .then(result => {
                alert(result);
                obtenerDatos();
                resetFormNuevoUsuario();
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }

}

function formatoNuevoUsuario() {

    let data = {};
    let permisos = "";
    let email = newUserMail.value;
    let password = newUserPass.value;

    const checks = document.querySelectorAll(".newUserAccessCheck");
    checks.forEach((check) => {
        if (check.checked) {
            permisos += check.value;
            permisos += ",";
        }
    });

    acceso = permisos.split(",");
    acceso = acceso.filter(acc => acc != "");

    data.email = email;
    data.password = password;
    data.roles = acceso;

    return data;
}

function resetFormNuevoUsuario(){
    formNewUser.reset(); 
    newUserMail.className = "form-control";
    newUserPass.className = "form-control";
    newUserMailErr.style.display = "none";
    newUserPassErr.style.display = "none";
    validForm = [false,false];
}

// -------------------- Editar usuario -------------------------

btnEditarUsuarioModal.addEventListener("click", () => {

    let valorSelectEditar = selectEditUser.value;

    if (valorSelectEditar != "") {
        data = formatEditarUsuario();
        textConfirmarEditarUsuario.innerHTML = `
        <span style="font-weight:bold;"> Se va a editar el usuario:</span> <br>
        <span style="font-weight:bold;">• Email:</span> "${data.email}" <br>
        <span style="font-weight:bold;">• Permisos:</span> "${data.roles.join(" - ")}".`;
        btnEditarUsuario.disabled = false;
    }else{
        textConfirmarEditarUsuario.innerHTML = "Ha ocurrido un error - Vuelva a intentarlo.";
        btnEditarUsuario.disabled = true;
    }

})

function validarFormEditarUsuario(){

    let valor = selectEditUser.value;

    if(valor != ""){
        btnEditarUsuarioModal.disabled = false;
    }else{
        btnEditarUsuarioModal.disabled = true;
    }
}

function editarUsuario(){

    let valorSelectEditar = selectEditUser.value;

    if (valorSelectEditar != "") {

        dataAll = formatEditarUsuario();
        data = {};
        data.id = dataAll.id;
        data.roles = dataAll.roles;

        const requestOptions = {
            method: "PUT",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
        };

        fetch(url, requestOptions)
            .then(response => response.text())
            .then(result => {
                alert(result);
                formEditUser.reset();
                selectEditUser.value = "";
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }
}

function formatEditarUsuario(){

    let data = {};
    let permisos = "";
    let valorSelectEditar = selectEditUser.value.split(",");
    let email = valorSelectEditar[0];
    let id = valorSelectEditar[1];

    const checks = document.querySelectorAll(".editUserAccessCheck");
    checks.forEach((check) => {
        if (check.checked) {
            permisos += check.value;
            permisos += ",";
        }
    });

    data.id = id;
    data.email = email;
    acceso = permisos.split(",");
    acceso = acceso.filter(acc => acc != "");
    data.roles = acceso;

    return(data);
}

// -------------------- Editar usuario -------------------------

function validarFormEliminarUsuario(){

    let valor = selectDeleteUser.value.split(",");

    if(valor.length == 2){
        btnEliminarUsuarioModal.disabled = false;
    }else{
        btnEliminarUsuarioModal.disabled = true;
    }
}

btnEliminarUsuarioModal.addEventListener("click",()=>{
    
    let valor = selectDeleteUser.value.split(",");

    if(valor.length == 2){
        textConfirmarEliminarUsuario.innerHTML = `
        <span style="font-weight:bold;"> Se va a eliminar el usuario:</span> <br>
        <span style="font-weight:bold;">• Email:</span> "${valor[0]}" <br>`;
    }else{
        textConfirmarEliminarUsuario.innerHTML = "Ha ocurrido un error - Vuelva a intentarlo.";
    }
})

function eliminarUsuario(){
    let valor = selectDeleteUser.value.split(",");
    if(valor.length == 2){

        let data = {};
        data.id = valor[1];

        const requestOptions = {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data),
        };

        fetch(url, requestOptions)
        .then(response => response.text())
        .then(result => {
            alert(result);
            formDelUser.reset();
            selectDeleteUser.value = "";
            obtenerDatos();
        })
        .catch(error => {
            console.error("Error:", error);
        });

    }

}

obtenerDatos();