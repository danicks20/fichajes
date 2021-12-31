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
            'copy', 'excel', 'pdf', 'print'
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
            { name: 'hora_entrada', data: 'hora_entrada', className: "tdLeft" },
            { name: 'hora_salida', data: 'hora_salida', className: "tdLeft" },
            { name: 'tiempo_total', data: 'tiempo_total', className: "tdLeft" },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // converting to interger to find total
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // computing column Total of the complete result 
            var Total = api
                .column('tiempo_total:name', { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return moment.duration(b).add(a);
                }, 0);
            
            if (Total != 0){
                // Update footer by showing the total with the reference of the column index 
                $(api.column('hora_salida:name').footer()).html('Total');
                $(api.column('tiempo_total:name').footer()).html(moment.utc(Total.asMilliseconds()).format('HH:mm:ss'));
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