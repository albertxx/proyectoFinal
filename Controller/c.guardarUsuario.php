<?php 
require_once "../Model/Usuario.php";
require_once "../Model/Personaje.php";
require_once "../Model/Misiones.php";


if(!isset($_COOKIE['usuario']) || $_COOKIE['usuario'] == ""){
    $data['usuario'] = Usuario::getUsuarioById($_REQUEST['nick']);
    setcookie('usuario', serialize($data['usuario']), time()+60*60*24);
}else{
    $data['usuario'] = unserialize($_COOKIE['usuario']);
}

$carpetaMisiones = "../View/img/misiones/";
$data['misiones'] = Misiones::getMisiones();


require_once "../View/paginaPrincipal.php";
?>