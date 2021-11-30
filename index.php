<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software fichajes</title>
    <!-- Compressed CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.7.4/dist/css/foundation.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/static/css/estilos.css">
</head>
<body>

    <?
        session_start();
        // Establecer timezone y localización
        setlocale(LC_ALL,"es_es.UTF-8");
        date_default_timezone_set("Europe/Madrid");

        // Constantes
        require("constantes.php");

        require("Models/RegistroHora.php");

        use RegistroHora\RegistroHora;
    ?>

    <form action="Php/fichaje_form.php" method="post">
        <div class="grid-container">
            <div class="grid-x grid-padding-x">
                <div class="cell text-center">
                    <h1>Software fichajes</h1>
                </div>
                <fieldset class="cell">
                    <legend><strong>Seleccione la empresa</strong></legend>
                    
                    <input type="radio" name="empresa" id="empresaKike" value="Kike" required
                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre']) echo 'disabled'; ?> 
                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre'] == "Kike") echo 'checked'; ?> 
                    ><label for="empresaKike">Kike</label>
                    
                    <input type="radio" name="empresa" id="empresaEdu" value="Edu"
                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre']) echo 'disabled'; ?> 
                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre'] == "Edu") echo 'checked'; ?> 
                    ><label for="empresaEdu">Edu</label>

                    <input type="radio" name="empresa" id="empresaEmilio" value="Emilio"
                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre']) echo 'disabled'; ?> 
                    <? if(isset($_SESSION['pdte_fichar_cierre']) && $_SESSION['pdte_fichar_cierre'] == "Emilio") echo 'checked'; ?>
                    ><label for="empresaEmilio">Talleres Emilio</label>
                </fieldset>
                <div class="cell">
                    <? if ((new RegistroHora)->cierrePending()): ?>
                        <button type="submit" class="button" name="ficha_salida">Fichar salida</button>
                    <? else: ?>
                        <button type="submit" class="button" name="ficha_entrada">Fichar entrada</button>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </form>
    


   <div class="grid-container">
        <div class="grid-x grid-padding-x">
            <div class="cell text-center"><?= strftime("%A %d de %B del %Y"); ?></div>
            <div class="cell text-center" style="margin-top: 10px;"><strong>Tiempo total: </strong><?= (new RegistroHora)->getTotalTime(); ?> horas.</div>
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