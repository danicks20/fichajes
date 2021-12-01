<?
    session_start();
    require_once("../constantes.php");
    require_once(BASEDIR."/Models/RegistroHora.php");
    use RegistroHora\RegistroHora;
    
    if (isset($_POST["filtrar"])){

        $empresa = $_POST["empresa"];
        $f_desde = $_POST["fecha_desde"];
        $f_hasta = $_POST["fecha_hasta"];

        $registros = (new RegistroHora)->filtroRegistros($empresa, $f_desde, $f_hasta);
        $_SESSION['filtro_empresa'] = $empresa;
        $_SESSION['filtro_desde'] = $f_desde;
        $_SESSION['filtro_hasta'] = $f_hasta;
        $_SESSION['registros_filtrados'] = $registros;
        header("Location: ".BASEURL."/templates/filtrar.php");
        die();
    } 
?>