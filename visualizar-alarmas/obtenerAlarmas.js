const urlAlarmas = "../includes/api/visualizar-alarmas/controller.php";

/* HTML Calls*/
const sinDatosAlarmas = document.getElementById("sinDatosAlarmas");
const table_alarmas = document.getElementById("table_alarmas");

// ---- Paginación 
const lastPage = document.getElementById("lastPage");
const pageActual = document.getElementById("pageActual");
const btnPrevPage = document.getElementById("btnPrevPage");
const btnNextPage = document.getElementById("btnNextPage");

// ---- Data variables
let alarmasData = [];
let filterAlarmasData = [];
let pageNumber = 0;

function obtenerProductosAlarmas() {
    fetch(urlAlarmas + "?productos=valor")
        .then(response => response.json())
        .then(data => {

            if (data.length > 0) {

                alarmasData = data;
                filterAlarmasTable(alarmasData);

            }

            if (data.length == 0) {

                sinDatosAlarmas.style.display = "flex";

            }


        })
}

function filterAlarmasTable(data) {

    table_alarmas.innerHTML = "";
    let filterAlarmasData = data.slice(pageNumber, pageNumber + 10);
    pageActual.textContent = String(pageNumber / 10 + 1);

    if (filterAlarmasData.length == 0) {
        btnNextPage.disabled = true;
        sinDatosAlarmas.style.display = "flex";
    }

    if (filterAlarmasData.length > 0) {
        sinDatosAlarmas.style.display = "none";
        btnNextPage.disabled = false;
    }

    lastPage.textContent = Math.ceil(data.length / 12) + 1;


    mostrarTabla(filterAlarmasData);

}

function mostrarTabla(dataAlarmas) {

    dataAlarmas.forEach(alarma => {

        let fila = document.createElement("tr");
        let producto = document.createElement("td");
        let sn = document.createElement("td");
        let cantidad = document.createElement("td");
        let stockAviso = document.createElement("td");
        let estado = document.createElement("td");
        let acciones = document.createElement("td");

        producto.textContent = alarma.name;
        sn.textContent = alarma.sn;
        cantidad.textContent = alarma.cant;
        stockAviso.textContent = alarma.stockAviso;
        estado.textContent = devolverEstado(alarma.estado);

        producto.style.textAlign = "center";
        sn.style.textAlign = "center";
        cantidad.style.textAlign = "center";
        stockAviso.style.textAlign = "center";
        estado.style.textAlign = "center";
        acciones.style.textAlign = "center";

        producto.style.verticalAlign = "middle";
        sn.style.verticalAlign = "middle";
        cantidad.style.verticalAlign = "middle";
        stockAviso.style.verticalAlign = "middle";
        estado.style.verticalAlign = "middle";


        fila.appendChild(producto);
        fila.appendChild(sn);
        fila.appendChild(cantidad);
        fila.appendChild(stockAviso);
        fila.appendChild(estado);

        table_alarmas.appendChild(fila);

    });

}

function devolverEstado(estado) {

    if (estado == "I") {

        return "Inactivo";

    }

    if (estado == "A") {

        return "Activo";

    }

    if (estado == "D") {

        return "Desactivada"

    }

}

obtenerProductosAlarmas();