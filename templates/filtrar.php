<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software fichajes</title>
    <!-- Compressed CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/css/foundation.min.css" crossorigin="anonymous">
    <link href="/fichajes/static/libs/fontawesome5/css/all.css" rel="stylesheet"> <!--load all styles -->
    <link href="/fichajes/static/libs/foundation-datepicker/css/foundation-datepicker.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.foundation.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.foundation.min.css">

    <link rel="stylesheet" href="/fichajes/static/css/estilos.css">
</head>
<body>

    <?
        session_start();
        // Establecer timezone y localización
        setlocale(LC_ALL,"es_es.UTF-8");
        date_default_timezone_set("Europe/Madrid");

        // Constantes
        require("../constantes.php");

        require(BASEDIR."/Models/RegistroHora.php");

        use RegistroHora\RegistroHora;

        if (isset($_SESSION['filtro_empresa'])){
            $filtro_empresa = $_SESSION['filtro_empresa'];
            $f_desde = $_SESSION['filtro_desde'];
            $f_hasta = $_SESSION['filtro_hasta'];
            $tiempo_total_filtro = (new RegistroHora)->sumTotalFilter($filtro_empresa, $f_desde, $f_hasta);
        }

    ?>

    <ul class="menu" style="background: black;">
        <li><a href="/fichajes"><i class="far fa-edit"></i> Fichar</a></li>
        <li><a href="/fichajes/templates/filtrar.php"><i class="fas fa-search"></i> Filtrar</a></li>
    </ul>

    <form action="../Php/filtros_form.php" method="post">
        <div class="grid-container">
            <div class="grid-x grid-margin-x grid-padding-x">
                <div class="cell text-center">
                    <h1><i class="fas fa-binoculars"></i> Filtrar</h1>
                </div>
                <fieldset class="cell text-center callout">
                    <legend><strong>Seleccione los filtros a realizar</strong></legend>
                    <div class="grid-x grid-margin-x grid-padding-x">
                        <div class="cell medium-6">
                            <fieldset class="text-center callout">
                                <legend>Seleccionar empresa</legend>
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-4 text-center">
                                        <label for="empresaKike">
                                            <!-- image has no padding -->
                                            <div class="card align-center-middle">
                                                <img src="/fichajes/static/img/Carlos.PNG">
                                                <div class="card-section text-center">
                                                    <p>Carlos Bueno</p>
                                                </div>
                                            </div>
                                        </label>
                                        <div>
                                            <input type="radio" name="empresa" id="empresaKike" value="Kike" required
                                                <? if(isset($_SESSION['filtro_empresa']) && $_SESSION['filtro_empresa'] == "Kike") echo 'checked'; ?> 
                                            >
                                        </div>
                                    </div>

                                    <div class="cell medium-4 text-center">
                                        <label for="empresaEdu">
                                            <!-- image has no padding -->
                                            <div class="card align-center-middle">
                                                <img src="/fichajes/static/img/Taxa.PNG">
                                                <div class="card-section text-center">
                                                    <p>Taxa peritaciones</p>
                                                </div>
                                            </div>
                                        </label>
                                        <div>
                                            <input type="radio" name="empresa" id="empresaEdu" value="Edu"
                                                <? if(isset($_SESSION['filtro_empresa']) && $_SESSION['filtro_empresa'] == "Edu") echo 'checked'; ?> 
                                            >
                                        </div>
                                    </div>

                                    <div class="cell medium-4 text-center">
                                        <label for="empresaEmilio">
                                            <!-- image has no padding -->
                                            <div class="card align-center-middle">
                                                <img src="/fichajes/static/img/Emilio.PNG">
                                                <div class="card-section text-center">
                                                    <p>Talleres Emilio</p>
                                                </div>
                                            </div>
                                        </label>
                                        <div>
                                            <input type="radio" name="empresa" id="empresaEmilio" value="Emilio" 
                                                <? if(isset($_SESSION['filtro_empresa']) && $_SESSION['filtro_empresa'] == "Emilio") echo 'checked'; ?>
                                            >
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="cell medium-6">
                            <fieldset class="text-center callout">
                                <legend>Rango fechas</legend>
                                <div class="grid-x grid-margin-x grid-padding-x">
                                    <!-- fecha desde -->
                                    <div class="small-1 cell">
                                        <label for="middle-label" class="text-right middle">Desde</label>
                                    </div>
                                    <div class="small-4 cell">
                                        <input type="text" name="fecha_desde" id="fecha_desde" autocomplete="off" required>
                                    </div>

                                    <!-- fecha hasta -->
                                    <div class="small-1 cell">
                                        <label for="middle-label" class="text-right middle">Hasta</label>
                                    </div>
                                    <div class="small-4 cell">
                                        <input type="text" name="fecha_hasta" id="fecha_hasta" autocomplete="off" required>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="cell">
                        <button type="submit" class="button" name="filtrar"><i class="fas fa-search"></i> Filtrar</button>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
    


   <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center">
                <i class="far fa-calendar-alt"></i>

                <? if (isset($_SESSION['filtro_desde'])): ?>
                    Filtro desde <?= ($_SESSION['filtro_desde'] ?? ''). ' hasta ' . ($_SESSION['filtro_hasta'] ?? ''); ?>
                <? else: ?>
                    <strong>Sin filtros seleccionados</strong>
                <? endif; ?>

            </div>
            <div class="cell text-center" style="margin-top: 10px;">

                <? if (isset($_SESSION['filtro_desde'])): ?>
                    <i class="far fa-clock"></i>
                    <strong>Tiempo total: </strong><?= $tiempo_total_filtro; ?> horas.
                <? else: ?>
                    
                <? endif; ?>  
            </div>
            <div class="cell text-center" style="margin-top: 50px;">
                <table id="tbFiltros" class="hover">
                    <thead>
                        <tr>
                            <th width="300">Empresa</th>
                            <th width="150">Fecha</th>
                            <th width="150">Entrada</th>
                            <th width="150">Salida</th>
                            <th width="150">Tiempo total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            if (isset($_SESSION['registros_filtrados'])){
                                foreach ($_SESSION['registros_filtrados'] as $row) {
                                    echo "<tr><td class='text-left'>${row['empresa']}</td><td class='text-left'>${row['fecha']}</td><td class='text-left'>${row['hora_entrada']}</td><td class='text-left'>${row['hora_salida']}</td><td class='text-left'>${row['tiempo_total']}</td></tr>";
                                }
                            }
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class='text-right'><strong>Total</strong></td>
                            <td class='text-left'><strong><?= $tiempo_total_filtro; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
   </div>


    <!-- Compressed JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/js/foundation.min.js" crossorigin="anonymous"></script>
    <script src="/fichajes/static/libs/foundation-datepicker/js/foundation-datepicker.js"></script>
    <script src="/fichajes/static/libs/foundation-datepicker/js/locales/foundation-datepicker.es.js"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.foundation.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.foundation.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
    

    <script>
        $(function() {
            $('#fecha_desde').fdatepicker({
                language: 'es',
                format: 'yyyy-mm-dd',
                disableDblClickSelection: true,
                leftArrow:'<<',
                rightArrow:'>>',
                closeIcon:'X',
                closeButton: true
            });

            $('#fecha_hasta').fdatepicker({
                language: 'es',
                format: 'yyyy-mm-dd',
                disableDblClickSelection: true,
                leftArrow:'<<',
                rightArrow:'>>',
                closeIcon:'X',
                closeButton: true
            });

            $('#tbFiltros').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                ordering: false
            });
        });
    </script>
</body>
</html>