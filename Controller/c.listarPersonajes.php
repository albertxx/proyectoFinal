<?php 

require_once "../Model/Usuario.php";
require_once "../Model/IvaliceBD.php";
require_once "../Model/Clases.php";
require_once "../Model/Personaje.php";


$nick = unserialize($_COOKIE['usuario'])->getNick();

$data['personajes'] = Personaje::getPersonajes($nick);
var_export($data['personajes']);
?>