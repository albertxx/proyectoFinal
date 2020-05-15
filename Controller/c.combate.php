<?php 

require_once "../Model/Personaje.php";
require_once "../Model/Estadisticas.php";
require_once "../Model/Habilidades.php";
require_once "../Model/Misiones.php";
$carpetaMisiones = "../View/img/misiones/";
$carpetaPersonajes = "../View/img/fotosPersonaje/";

$data['personajeSeleccionado'] = Personaje::getPersonajeById($_POST['idPersonaje']);
$data['estadisticas'] = Estadisticas::getEstadisticasByPersonaje($_POST['idPersonaje']);
$data['mision'] = Misiones::getMisionById($_POST['idMision']);

require_once "../View/combate.php";

?>