<?php 

require_once "../Model/Usuario.php";
require_once "../Model/IvaliceBD.php";
require_once "../Model/Clases.php";
require_once "../Model/Personaje.php";
require_once "../Model/Estadisticas.php";

$nick = unserialize($_COOKIE['usuario'])->getNick();
$carpetaFotosPersonaje = "../View/img/fotosPersonaje/";
$data['usuarioActual'] = Usuario::getUsuarioById($nick);

$data['personajes'] = Personaje::getPersonajesByNick($nick);
require_once "../View/listadoPersonajes.php";
?>