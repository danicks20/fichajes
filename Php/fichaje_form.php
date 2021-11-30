<?
    session_start();
    require_once("../constantes.php");
    require_once(BASEDIR."/Models/RegistroHora.php");
    use RegistroHora\RegistroHora;
    
    if (isset($_POST["ficha_entrada"])){
        $empresa = $_POST["empresa"];
        if ($empresa){
            (new RegistroHora)->registrarEntrada($empresa);
            $_SESSION['pdte_fichar_cierre'] = $empresa;
            header("Location: ".BASEURL);
            die();
        }
    }  
    
    if (isset($_POST["ficha_salida"])){
        (new RegistroHora)->registrarSalida();
        $_SESSION['pdte_fichar_cierre'] = false;
        header("Location: ".BASEURL);
        die();
    } 
?>