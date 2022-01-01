<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software fichajes</title>
    <!-- Compressed CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/css/foundation.min.css" crossorigin="anonymous">
    <link href="/fichajes/static/libs/fontawesome5/css/all.css" rel="stylesheet">
    <!--load all styles -->
    <link href="/fichajes/static/libs/foundation-datepicker/css/foundation-datepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.foundation.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.foundation.min.css">

    <link rel="stylesheet" href="/fichajes/static/css/estilos.css">
</head>

<body>

    <?
    session_start();
    // Establecer timezone y localización
    setlocale(LC_ALL, "es_es.UTF-8");
    date_default_timezone_set("Europe/Madrid");

    // Constantes
    require("../constantes.php");

    require(BASEDIR . "/Models/RegistroHora.php");

    use RegistroHora\RegistroHora;

    if (isset($_SESSION['filtro_empresa'])) {
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

    <form id='filtrosForm' action="../Php/filtros_form.php" method="post">
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
                                <div class="grid-x">
                                    <div class='small-5 cell'>
                                        <div class='grid-x'>
                                            <div class='small-9 cell text-right'>
                                                <label for='kike' style='margin-right: 5px;'>Carlos Bueno</label>
                                            </div>
                                            <div class='small-3 cell text-left'>
                                                <div class='switch tiny'>
                                                    <input class='switch-input filterCheck' id='kike' type='checkbox' name='kike'>
                                                    <label class='switch-paddle' for='kike'>
                                                        <span class='show-for-sr'>$name activo</span>
                                                        <span class='switch-active' aria-hidden='true'>SI</span>
                                                        <span class='switch-inactive' aria-hidden='true'>NO</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='small-5 cell'>
                                        <div class='grid-x'>
                                            <div class='small-9 cell text-right'>
                                                <label for='edu' style='margin-right: 5px;'>Taxa peritaciones</label>
                                            </div>
                                            <div class='small-3 cell text-left'>
                                                <div class='switch tiny'>
                                                    <input class='switch-input filterCheck' id='edu' type='checkbox' name='edu'>
                                                    <label class='switch-paddle' for='edu'>
                                                        <span class='show-for-sr'>$name activo</span>
                                                        <span class='switch-active' aria-hidden='true'>SI</span>
                                                        <span class='switch-inactive' aria-hidden='true'>NO</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='small-5 cell'>
                                        <div class='grid-x'>
                                            <div class='small-9 cell text-right'>
                                                <label for='emilio' style='margin-right: 5px;'>Talleres Emilio</label>
                                            </div>
                                            <div class='small-3 cell text-left'>
                                                <div class='switch tiny'>
                                                    <input class='switch-input filterCheck' id='emilio' type='checkbox' name='emilio'>
                                                    <label class='switch-paddle' for='emilio'>
                                                        <span class='show-for-sr'>$name activo</span>
                                                        <span class='switch-active' aria-hidden='true'>SI</span>
                                                        <span class='switch-inactive' aria-hidden='true'>NO</span>
                                                    </label>
                                                </div>
                                            </div>
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

                        <div class="cell medium-6"" style=" display: flex; margin-top: 10px;">
                            <div>Agrupar por días y empresa</div>
                            <div class="switch tiny" style="margin-left: 10px;">
                                <input class="switch-input" id="groupByDays" name="groupByDays" type="checkbox">
                                <label class="switch-paddle" for="groupByDays">
                                    <span class="show-for-sr">Agrupar por días</span>
                                    <span class="switch-active" aria-hidden="true">Si</span>
                                    <span class="switch-inactive" aria-hidden="true">No</span>
                                </label>
                            </div>
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
                <table id="tbFiltros" class="hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Empresa</th>
                            <th>Fecha</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Tiempo total</th>
                            <th>Día</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot align="right">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <!-- Compressed JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/js/foundation.min.js" crossorigin="anonymous"></script>
    <script src="/fichajes/static/libs/foundation-datepicker/js/foundation-datepicker.js"></script>
    <script src="/fichajes/static/libs/foundation-datepicker/js/locales/foundation-datepicker.es.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.min.js"></script>

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
    <script src="/fichajes/static/js/filtrar.js"></script>

</body>

</html>