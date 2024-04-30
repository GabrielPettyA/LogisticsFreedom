$(document).ready(function () {
    $('#ventas').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        scrollX: true, // Cambiado a true para permitir el desplazamiento horizontal si es necesario
        lengthMenu: [[10, 15, 20, -1], [ 10, 15,  20, "TODOS"]],
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

window.addEventListener('resize', () => {
    if (chart) {
      chart.resize(); // Reajusta el gráfico al cambiar el tamaño de la pantalla
    }
  });

