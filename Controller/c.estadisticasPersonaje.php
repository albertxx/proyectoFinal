<?php 

require_once "../Model/Estadisticas.php";
require_once "../Model/Personaje.php";

$estadisticas = Estadisticas::getEstadisticasByPersonaje($_REQUEST['idPersonaje']);
$nombrePersonaje = Personaje::getPersonajeById($_REQUEST['idPersonaje']);
$estadisticasPersonaje = [
    "nombre_personaje" => $nombrePersonaje->getNombre(),
    "vida" =>  $estadisticas->getVida(),
    "atk" => $estadisticas->getAtk(),
    "def" => $estadisticas->getDef(),
    "magia" => $estadisticas->getMagia(),
    "pm" => $estadisticas->getPm(),
    "ph" => $estadisticas->getPh()
];

echo json_encode($estadisticasPersonaje);
?>