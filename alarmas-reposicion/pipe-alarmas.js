// ---- Filtros HTML
const productoSearch = document.getElementById("productoSearch");
const snSearch = document.getElementById("snSearch");
const cantidadSearch = document.getElementById("cantidadSearch");
const stockAvisoSearch = document.getElementById("stockAvisoSearch");
const estadoSearch = document.getElementById("estadoSearch");
const resetSearch = document.getElementById("resetSearch");

function filterTable() {

    // ---- Valores de búsqueda
    let productos = productoSearch.value;
    let sn = snSearch.value;
    let cantidad = cantidadSearch.value;
    let aviso = stockAvisoSearch.value;
    let estado = estadoSearch.value;

    if (productos == "" && sn == "" && cantidad == "" && aviso == "" && estado == "") {

        console.log("Sin cambios en la búsqueda.");
        return filterAlarmasTable(alarmasData);

    }

    let busqueda = [];

    if (estado != "") {

        busqueda = alarmasData.filter(element => element.estado == estado);

    }

    if (aviso != "") {

        if (busqueda.length == 0) {

            busqueda = alarmasData.filter(element => element.stockAviso.includes(aviso));

        }

        if (busqueda.length > 0) {

            busqueda = busqueda.filter(element => element.stockAviso.includes(aviso));

        }

    }

    if (cantidad != "") {

        if (busqueda.length == 0) {

            busqueda = alarmasData.filter(element => element.cant.includes(cantidad));

        }

        if (busqueda.length > 0) {

            busqueda = busqueda.filter(element => element.cant.includes(cantidad));


        }

    }

    if (sn != "") {

        if (busqueda.length == 0) {

            busqueda = alarmasData.filter(element => element.sn.includes(sn));

        }

        if (busqueda.length > 0) {

            busqueda = busqueda.filter(element => element.sn.includes(sn));


        }

    }

    if (productos != "") {

        if (busqueda.length == 0) {

            busqueda = alarmasData.filter(element => element.name.toLowerCase().includes(productos.toLowerCase()));

        }

        if (busqueda.length > 0) {

            busqueda = busqueda.filter(element => element.name.toLowerCase().includes(productos.toLowerCase()));


        }

    }

    if (busqueda.length > 0) {

        sinDatosAlarmas.style.display = "none";
        return filterAlarmasTable(busqueda);

    }

    if (busqueda.length == 0) {

        sinDatosAlarmas.style.display = "flex";
        return filterAlarmasTable(busqueda);

    }

}

function resetBusqueda() {

    productoSearch.value = "";
    snSearch.value = "";
    cantidadSearch.value = "";
    stockAvisoSearch.value = "";
    estadoSearch.value = "";

    filterTable();

}