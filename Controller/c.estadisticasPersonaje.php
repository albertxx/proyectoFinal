<?php 

require_once "../Model/Estadisticas.php";

$estadisticas = Estadisticas::getEstadisticasByPersonaje($_REQUEST['idPersonaje']);
$estadisticasPersonaje = [
    "vida" =>  $estadisticas->getVida(),
    "atk" => $estadisticas->getAtk(),
    "def" => $estadisticas->getDef(),
    "magia" => $estadisticas->getMagia(),
    "pm" => $estadisticas->getPm(),
    "ph" => $estadisticas->getPh()
];

echo json_encode($estadisticasPersonaje);
?>