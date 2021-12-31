var filtros = {};
var filterTable;

$(function() {
    $('#fecha_desde').fdatepicker({
        language: 'es',
        format: 'yyyy-mm-dd',
        disableDblClickSelection: true,
        leftArrow: '<<',
        rightArrow: '>>',
        closeIcon: 'X',
        closeButton: true
    });

    $('#fecha_hasta').fdatepicker({
        language: 'es',
        format: 'yyyy-mm-dd',
        disableDblClickSelection: true,
        leftArrow: '<<',
        rightArrow: '>>',
        closeIcon: 'X',
        closeButton: true
    });

    var columns_export = [ 
        'empresa:name', 'fecha:name', 'dia:name',
        'hora_entrada:name', 'hora_salida:name', 'tiempo_total:name',
    ]

    filterTable = $('#tbFiltros').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
        },
        dom: 'Blfrtip',
        autoWidth: false,
        stateSave: true,
        pageLength: 100,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todo"]],
        buttons: [
            {
                extend:    'copyHtml5',
                text:      '<i class="far fa-copy"></i> Copiar',
                titleAttr: 'Copiar'
            }, 
            {
                extend:    'excelHtml5',
                text:      '<i class="far fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                exportOptions: {
                    columns: columns_export
                }
            }, 
            {
                extend:    'print',
                text:      '<i class="fas fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                exportOptions: {
                    columns: columns_export
                }
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="far fa-file-pdf"></i> PDF',
                title: 'Listado fichajes',
                /* customize: function(doc) {
                    doc.styles.title = {
                        color: 'red',
                        fontSize: '40',
                        background: 'blue',
                        alignment: 'center'
                    }   
                },  */ 
                /* messageTop: function(){
                    return "Listado peritaciones";
                }, */
                footer: true,
                exportOptions: {
                    columns: columns_export
                }
            },
        ],
        ordering: false,
        ajax: {
            url: "../Php/filtros_form.php",
            type: 'POST',
            data: function (d) {
                d.filtros = filtros;
            }
        },
        columns: [
            { name: 'id', data: 'id', className: "tdRight", visible: false },
            { name: 'empresa', data: 'empresa', className: "tdLeft" },
            { name: 'fecha', data: 'fecha', className: "tdLeft" },
            { name: 'dia', data: 'dia', className: "tdLeft" },
            { name: 'hora_entrada', data: 'hora_entrada', className: "tdLeft" },
            { name: 'hora_salida', data: 'hora_salida', className: "tdLeft" },
            { name: 'tiempo_total', data: 'tiempo_total', className: "tdLeft" },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // converting milliseconds to hours, minutes, seconds...
            function parseMillisecondsIntoReadableTime(milliseconds){
                //Get hours from milliseconds
                var hours = milliseconds / (1000*60*60);
                var absoluteHours = Math.floor(hours);
                var h = absoluteHours > 9 ? absoluteHours : '0' + absoluteHours;
              
                //Get remainder from hours and convert to minutes
                var minutes = (hours - absoluteHours) * 60;
                var absoluteMinutes = Math.floor(minutes);
                var m = absoluteMinutes > 9 ? absoluteMinutes : '0' +  absoluteMinutes;
              
                //Get remainder from minutes and convert to seconds
                var seconds = (minutes - absoluteMinutes) * 60;
                var absoluteSeconds = Math.floor(seconds);
                var s = absoluteSeconds > 9 ? absoluteSeconds : '0' + absoluteSeconds;
              
              
                return h + ':' + m + ':' + s;
              }

            // computing column Total of the complete result 
            var Total = api
                .column('tiempo_total:name', { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return moment.duration(b).add(a);
                }, 0);
            
            if (Total != 0){
                var milliseconds = Total.asMilliseconds();
        
                // Update footer by showing the total with the reference of the column index 
                $(api.column('hora_salida:name').footer()).html('Total');
                $(api.column('tiempo_total:name').footer()).html(parseMillisecondsIntoReadableTime(milliseconds));
            }
            
        },
    });

    // add peritacion
    $("#filtrosForm").submit(function(e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        filtros = form.serialize();
        filterTable.ajax.reload();
    });

});