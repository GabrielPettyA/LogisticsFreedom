$(document).ready(function () {
    $('#tablaMod').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        scrollX: "2000px",
        lengthMenu: [[5,10,20, -1],[5,10,20,"Mostrar Todo"]],
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        columnDefs: [
            { className: "pp", targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10] },
            //{ orderable: false, targets: [5, 6] },
            //{ searchable: false, targets: [1] }
            //{ width: "50%", targets: [0] }
        ],

        //para usar los botones   
        responsive: "true",
        dom: 'Bfrtilp',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> ',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> ',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> ',
                titleAttr: 'Imprimir',
                className: 'btn btn-info'
            },
        ]
    });
});