const url = "../includes/api/ventas-api/ventas.php";

// Data variables 
let listadeventas = [];

const dailyData = [];
const dailyLabels = [];

function verventas() {
    fetch(url)
        .then(response => response.json())
        .then(data => {


            listadeventas = data;
            //console.log(listadeventas)
            data.forEach(element => {
                dailyData.push(element.cantidad_vendida)
                dailyLabels.push(element.fecha)
            });
        })


}
verventas()




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

// const dailyData = [3, 5, 2, 1, 4, 7, 6, 5, 3, 8]; // Datos de ejemplo
// const dailyLabels = ['Día 1', 'Día 2', 'Día 3', 'Día 4', 'Día 5', 'Día 6', 'Día 7', 'Día 8', 'Día 9', 'Día 10']; // Etiquetas de ejemplo

const monthlyData = [12, 19, 3, 5, 2, 3, 6, 2, 4, 5, 8, 23];
const monthlyLabels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

const annualData = [123, 140, 110, 150, 134]; // Datos de ejemplo para años
const annualLabels = ['2019', '2020', '2021', '2022', '2023']; // Etiquetas de ejemplo para años

createChart('Mensual', monthlyData, monthlyLabels); // Muestra el gráfico mensual por defecto

document.getElementById('daily').addEventListener('click', () => {
    createChart('nombredelproducto', dailyData, dailyLabels); // Cambia al gráfico diario
});

document.getElementById('monthly').addEventListener('click', () => {
    createChart('Mensual', monthlyData, monthlyLabels); // Cambia al gráfico mensual
});

document.getElementById('annual').addEventListener('click', () => {
    createChart('Anual', annualData, annualLabels); // Cambia al gráfico anual
});