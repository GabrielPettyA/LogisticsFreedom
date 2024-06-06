// ---- Modales
const editarAlarma = document.getElementById("editarAlarma");
const editarAlarmaLabel = document.getElementById("editarAlarmaLabel");


// ---- Form Editar Alarma
const editarEstado = document.getElementById("editarEstado");
const editarStockAviso = document.getElementById("editarStockAviso");
const btnEditarAlarma = document.getElementById("btnEditarAlarma");

// ---- Data variables Form
let isValidEditar = [true, true];
let alarmaAeditar = {};

function editarAlarmaModal(alarma) {

    let modal = new bootstrap.Modal(editarAlarma);
    modal.show();
    editarAlarmaLabel.textContent = "Editar alarma - Producto SN: " + alarma.sn;

    editarStockAviso.value = alarma.stockAviso;
    editarEstado.value = alarma.estado;

    alarmaAeditar = alarma;

}

function cerrarModal() {

    editarStockAviso.value = "";
    editarEstado.value = "";
    editarEstado.classList.remove("is-valid");
    editarEstado.classList.remove("is-invalid");
    editarStockAviso.classList.remove("is-valid");
    editarStockAviso.classList.remove("is-invalid");
    btnEditarAlarma.disabled = false;
    isValidEditar = [true, true];

}

function validarEstado() {

    let estado = editarEstado.value;

    if (estado != "I" || estado != "A" || estado != "D") {

        editarEstado.classList.remove("is-valid");
        editarEstado.classList.add("is-invalid");
        isValidEditar[0] = false;

    }

    if (estado == "I" || estado == "A" || estado == "D") {

        editarEstado.classList.remove("is-invalid");
        editarEstado.classList.add("is-valid");
        isValidEditar[0] = true;

    }

    habilitarEdicion();

}

function validarStockAviso() {

    let stockAviso = Number(editarStockAviso.value);

    if (stockAviso < 0 || stockAviso > 10000 ) {

        editarStockAviso.classList.remove("is-valid");
        editarStockAviso.classList.add("is-invalid");
        isValidEditar[1] = false;

    }

    if (stockAviso >= 0 && stockAviso <= 10000 ) {

        editarStockAviso.classList.remove("is-invalid");
        editarStockAviso.classList.add("is-valid");
        isValidEditar[1] = true;

    }

    habilitarEdicion();

}

function habilitarEdicion(){

    const isValid = isValidEditar.filter(element => element == true);

    if(isValid.length == 2){

        return btnEditarAlarma.disabled = false;
    }

    return btnEditarAlarma.disabled = true;

}


function editarAlarmaApi(usuario){

    const isValid = isValidEditar.filter(element => element == true);

    if(isValid.length != 2){

        alert("El formulario no es válido.");
        return;

    }

    if(alarmaAeditar.stockAviso == editarStockAviso.value && alarmaAeditar.estado == editarEstado.value){

        alert("No se registraron cambios en la solicitud. Operacion cancelada.");
        return;

    }

    let alarmaEditada = alarmaAeditar;

    alarmaEditada.stockAviso = editarStockAviso.value;
    alarmaEditada.estado = editarEstado.value;
    alarmaEditada.motivo = "CONFIG MANUAL";
    alarmaEditada.modificadaPor = usuario;

    const requestOptions = {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(alarmaEditada),
    };

    fetch(urlAlarmas,requestOptions)
    .then(response => response.json())
    .then(resp => {

        if(resp){

            alert("Se ha editado la alarma seleccionada.");
            resetBusqueda();
            obtenerProductosAlarmas();
            cerrarModal();
            alarmaAeditar = {};

        }

        if(!resp){

            alert("No se pueden setear alarmas con stock de aviso menor a '0'.");

        }

    })

}