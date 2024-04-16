const urlAlarmas = "../includes/api/alarmas-reposicion-api/controller.php";

/* HTML Calls*/
const sinDatosAlarmas = document.getElementById("sinDatosAlarmas");
const table_alarmas = document.getElementById("table_alarmas");

// Paginación 
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
                filterAlarmasTable();

            }

            if (data.length == 0) {

                sinDatosAlarmas.style.display = "flex";

            }


        })
}

function filterAlarmasTable() {

    table_alarmas.innerHTML = "";
    let filterAlarmasData = alarmasData.slice(pageNumber, pageNumber + 10);
    pageActual.textContent = String(pageNumber + 1);
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
        

        // Acciones
        let button_edit = document.createElement("button");
        let i_edit = document.createElement("i");
        let button_info = document.createElement("button");
        let i_info = document.createElement("i");

        // Acciones
        button_edit.className = "btn btn-warning m-1";
        i_edit.className = "fa-solid fa-pen-to-square";


        button_info.className = "btn btn-info m-1";
        i_info.className = "fa-regular fa-lightbulb";

        button_edit.appendChild(i_edit);
        button_info.appendChild(i_info);

        acciones.appendChild(button_edit);
        acciones.appendChild(button_info);

        fila.appendChild(producto);
        fila.appendChild(sn);
        fila.appendChild(cantidad);
        fila.appendChild(stockAviso);
        fila.appendChild(estado);
        fila.appendChild(acciones);

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