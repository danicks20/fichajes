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
    <link rel="stylesheet" href="/fichajes/static/css/estilos.css">
</head>
<body>

    <?
        session_start();
        // Establecer timezone y localización
        setlocale(LC_ALL,"es_es.UTF-8");
        date_default_timezone_set("Europe/Madrid");

        // Constantes
        require("constantes.php");

        require(BASEDIR."/Models/RegistroHora.php");

        use RegistroHora\RegistroHora;
    ?>

    <ul class="menu" style="background: black;">
        <li><a href="/fichajes"><i class="far fa-edit"></i> Fichar</a></li>
        <li><a href="/fichajes/templates/filtrar.php"><i class="fas fa-search"></i> Filtrar</a></li>
    </ul>

    <form action="Php/fichaje_form.php" method="post">
        <div class="grid-container">
            <div class="grid-x grid-margin-x grid-padding-x">
                <div class="cell text-center">
                    <h1><i class="far fa-edit"></i> Fichajes</h1>
                </div>
                <fieldset class="cell text-center callout">
                    <legend><strong>Seleccione la empresa</strong></legend>
                    
                    <div class="grid-x grid-padding-x">
                        <div class="cell medium-4 text-center">
                            <label for="empresaKike">
                                <!-- image has no padding -->
                                <div class="card align-center-middle">
                                    <img src="static/img/Carlos.PNG">
                                    <div class="card-section text-center">
                                        <p>Carlos Bueno peritaciones</p>
                                    </div>
                                </div>
                            </label>
                            <div>
                                <input type="radio" name="empresa" id="empresaKike" value="Kike" required
                                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre']) echo 'disabled'; ?> 
                                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre'] == "Kike") echo 'checked'; ?> 
                                >
                            </div>
                        </div>

                        <div class="cell medium-4 text-center">
                            <label for="empresaEdu">
                                <!-- image has no padding -->
                                <div class="card align-center-middle">
                                    <img src="static/img/Taxa.PNG">
                                    <div class="card-section text-center">
                                        <p>Taxa peritaciones</p>
                                    </div>
                                </div>
                            </label>
                            <div>
                                <input type="radio" name="empresa" id="empresaEdu" value="Edu"
                                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre']) echo 'disabled'; ?> 
                                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre'] == "Edu") echo 'checked'; ?> 
                                >
                            </div>
                        </div>

                        <div class="cell medium-4 text-center">
                            <label for="empresaEmilio">
                                <!-- image has no padding -->
                                <div class="card align-center-middle">
                                    <img src="static/img/Emilio.PNG">
                                    <div class="card-section text-center">
                                        <p>Talleres Emilio</p>
                                    </div>
                                </div>
                            </label>
                            <div>
                                <input type="radio" name="empresa" id="empresaEmilio" value="Emilio"
                                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre']) echo 'disabled'; ?> 
                                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre'] == "Emilio") echo 'checked'; ?>
                                >
                            </div>
                        </div>
                    </div>

                    <div class="cell">
                        <? if ((new RegistroHora)->cierrePending()): ?>
                            <button type="submit" class="button alert" name="ficha_salida">Fichar salida <i class="fas fa-sign-out-alt"></i></button>
                        <? else: ?>
                            <button type="submit" class="button" name="ficha_entrada"><i class="fas fa-sign-in-alt"></i> Fichar entrada</button>
                        <? endif; ?>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
    


   <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center">
                <i class="far fa-calendar-alt"></i>
                <?= strftime("%A %d de %B del %Y"); ?>
            </div>
            <div class="cell text-center" style="margin-top: 10px;">
                <i class="far fa-clock"></i>
                <strong>Tiempo total: </strong><?= (new RegistroHora)->getTotalTime(); ?> horas.
            </div>
            <div class="cell text-center" style="margin-top: 50px;">
                <table class="hover">
                    <thead>
                        <tr>
                            <th width="300">Empresa</th>
                            <th width="150">Entrada</th>
                            <th width="150">Salida</th>
                            <th width="150">Tiempo total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                            $res = (new RegistroHora)->getAllRegistrosToday();
                            foreach ($res->fetch_all(MYSQLI_ASSOC) as $row) {
                                echo "<tr><td class='text-left'>${row['empresa']}</td><td class='text-left'>${row['hora_entrada']}</td><td class='text-left'>${row['hora_salida']}</td><td class='text-left'>${row['tiempo_total']}</td></tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
   </div>


    <!-- Compressed JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/js/foundation.min.js" crossorigin="anonymous"></script>
</body>
</html>