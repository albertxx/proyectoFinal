<?php 
require_once "../Model/Usuario.php";

if(!isset($_COOKIE['usuario']) || $_COOKIE['usuario'] == ""){
    $data['usuario'] = Usuario::getUsuarioById($_REQUEST['nick']);
    setcookie('usuario', serialize($data['usuario']), time()+60*60*24);
}else{
    $data['usuario'] = unserialize($_COOKIE['usuario']);
}

require_once "../View/paginaPrincipal.php";
?>