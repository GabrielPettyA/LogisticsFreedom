const urlMod = "../includes/api/alarmas-reposicion-api/modController.php?id="

// ---- Modales
const verModAlarmas = document.getElementById("verModAlarmas");
const modalInfoMod = document.getElementById("modalInfoMod");

function obtenerModAlarmas(id) {

    modalInfoMod.innerHTML = "";
    let url = urlMod + id;

    const requestOptions = {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        },
    };

    fetch(url, requestOptions)
        .then(response => response.json())
        .then(resp => {

            if (resp.length > 0) {

                mostrarInformacionModal(resp);

            }

            if (resp.length == 0) {

                let p = document.createElement("p");

                p.textContent = "No existen datos para mostrar";

                modalInfoMod.appendChild(p);

            }

            verModAlarmasModal();

        })

}

function verModAlarmasModal() {

    let modal = new bootstrap.Modal(verModAlarmas);
    modal.show();

}

function mostrarInformacionModal(data) {

    data.forEach(element => {

        let contenedor = document.createElement("div");

        let modificadaPor = document.createElement("p");
        let motivo = document.createElement("p");
        let cant_old = document.createElement("p");
        let cant_new = document.createElement("p");
        let estadoAnterior = document.createElement("p");
        let fechaMod = document.createElement("p");

        contenedor.style.width = "95%";
        contenedor.style.margin = "auto";

        modificadaPor.textContent = "Modificada por: " + element.modificadaPor;
        motivo.textContent = "Motivo: " + element.motivo;
        cant_old.textContent = "Stock de aviso anterior: " + element.cant_old;
        cant_new.textContent = "Stock de aviso nuevo: " + element.cant_new;
        estadoAnterior.textContent = "Estado anterior: " + devolverEstado(element.estadoAnterior);
        fechaMod.textContent = "Fecha de modificación: " + element.fechaMod;

        contenedor.appendChild(modificadaPor);
        contenedor.appendChild(motivo);
        contenedor.appendChild(cant_old);
        contenedor.appendChild(cant_new);
        contenedor.appendChild(estadoAnterior);
        contenedor.appendChild(fechaMod);

        modalInfoMod.appendChild(contenedor);

        if (data.indexOf(element) < data.length -1) {


            let division = document.createElement("hr");

            modalInfoMod.appendChild(division);

        }



    });

}


