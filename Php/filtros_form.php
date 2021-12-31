<?
    session_start();
    require_once("../constantes.php");
    require_once(BASEDIR."/Models/RegistroHora.php");
    use RegistroHora\RegistroHora;
    

    if (!isset($_POST['filtros'])) die(json_encode(["data" => []]));
    $filtros = [];
    parse_str($_POST['filtros'], $filtros);
    $registros = (new RegistroHora)->filtroRegistros($filtros);
    echo json_encode(["data" => $registros]);
?>