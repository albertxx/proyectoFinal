<?php 

require_once "../Model/Usuario.php";

$nick = unserialize($_COOKIE['usuario'])->getNick();
$data['usuarioActual'] = Usuario::getUsuarioById($nick);
require_once "../View/crearPersonaje.php";
?>