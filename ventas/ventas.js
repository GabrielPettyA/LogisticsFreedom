const url = "../includes/api/ventas-api/ventas.php";


const confirmarventastabla = document.getElementById("confirmarventastabla")








$(document).ready(function () {
    $('#ventas').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        scrollX: true, // Cambiado a true para permitir el desplazamiento horizontal si es necesario
        lengthMenu: [[10, 15, 20, -1], [10, 15, 20, "TODOS"]],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        columnDefs: [
            { className: "pp", targets: [0, 1, 2, 3, 4] }, // Reducido a solo las columnas visibles
        ],

    });
});

// Función para habilitar o deshabilitar la cantidad de venta
function habilitarCantidad(checkbox) {
    var cantidadInput = checkbox.closest('tr').querySelector('input[type="number"]');
    cantidadInput.disabled = !checkbox.checked;
    if (!checkbox.checked) {
        cantidadInput.value = 0;
    }
}



function comprarealizada() {
    //hacer la resta en la tabla de stock

}
////////////////////////////////////
//Mostrar input

 let ventas = [];

function btnenviarcant() {
    ventas = []
    confirmarventastabla.innerHTML = ""

    let cantidadInput = document.querySelectorAll(".cantventas");
    let nombredeventas = document.querySelectorAll(".nombreVentas");


    for (let i = 0; i < cantidadInput.length; i++) {
        let valorcantidad = cantidadInput[i].value;
        let producto = nombredeventas[i].textContent;

        if (valorcantidad > 0 ){
            let venta = {};
            venta.producto = producto;
            venta.cant = valorcantidad;
            ventas.push(venta) 
        }
        
    }
    ventas.forEach(venta=>{
        let fila = document.createElement("tr");
        let cant = document.createElement("td");
        let prod = document.createElement("td");
        cant.textContent = venta.cant;
        prod.textContent = venta.producto;
        fila.appendChild(prod);
        fila.appendChild(cant);
        confirmarventastabla.appendChild(fila);
    })
}

function vender(){
    if (ventas.length==0){
        alert("NO SE HAN SELECCIONADO PRODUTOS PARA VENDER")
        return
    }
    const requestOptions = {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(ventas)

    };
    fetch(url , requestOptions)
    .then(response=>response.text()).then(result=>{
        console.log(result);

    }).catch(error=>{
        console.log(error);
    })
}

