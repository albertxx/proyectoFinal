<?php 

require_once "../Model/Usuario.php";
require_once "../Model/IvaliceBD.php";
require_once "../Model/Clases.php";

$nick = unserialize($_COOKIE['usuario'])->getNick();
$data['usuarioActual'] = Usuario::getUsuarioById($nick);
$data['clases'] = Clase::getClases();
require_once "../View/crearPersonaje.php";
?>