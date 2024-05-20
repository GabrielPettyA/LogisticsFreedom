const url = "../includes/api/ventas-api/ventas.php";
const urlProd = "../includes/api/stock-api/stock.php";

//---- HTML REF
const datalistOptions = document.getElementById("datalistOptions");
const datalistProd = document.getElementById("datalistProd");
const desdeFecha = document.getElementById("desdeFecha");
const hastaFecha = document.getElementById("hastaFecha");
const graficaVentas = document.getElementById("graficaVentas");


// Data variables 
let listadeventas = [];
let listaProductos = [];
let productoSeleccionado = "";
let cantidad = [];
let fechas = [];

const dailyData = [];
const dailyLabels = [];

function verventas() {
    fetch(url)
        .then(response => response.json())
        .then(data => {


            listadeventas = data;

        })


}

function verProductos() {

    fetch(urlProd + "?productos=valor")
        .then(response => response.json())
        .then(data => {

            listaProductos = data;

            data.forEach(producto => {

                let option = document.createElement("option");
                option.value = producto.name;

                datalistOptions.appendChild(option);

            })

        })


}

verProductos();
verventas();

function realizarBusqueda() {

    cantidad = [];
    fechas = [];

    producto = datalistProd.value;
    desde = desdeFecha.value + " 00:00:00";
    hasta = hastaFecha.value + " 23:59:59";

    const result = listadeventas.filter(dato => dato.name == producto);
    const filtradodesde = result.filter(dato => dato.fecha >= desde);
    const filtradohasta = filtradodesde.filter(dato => dato.fecha <= hasta);

    if(filtradohasta.length == 0){

        alert("No hay resultados para la busqueda.");
        cantidad = [];
        fechas = [];
        graficaVentas.style.display = "none";
        return;

    }

    productoSeleccionado = producto;

    filtradohasta.forEach(element=>{

        cantidad.push(element.cantidad);
        fechas.push(element.fecha);

    })

    createChart(productoSeleccionado, cantidad, fechas);
    graficaVentas.style.display = "block";

    console.log(cantidad, fechas)



}


const ctx = document.getElementById('myChart');
let chart;

const createChart = (type, data, label) => {
    if (chart) chart.destroy(); // Destruye el gráfico anterior
    chart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico (puede ser bar, line, etc.)
        data: {
            labels: label, // Etiquetas para el eje X
            datasets: [{
                label: type, // Etiqueta para el gráfico
                data: data, // Datos para el gráfico
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
            }],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
};
