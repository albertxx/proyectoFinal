<?php 
session_start();

require_once "../Model/Enemigos.php";
require_once "../Model/HabilidadesEnemigos.php";
require_once "../Model/Estadisticas.php";

$enemigo = Enemigos::getEnemigoByIdMision($_REQUEST['idMision']);
$habilidadesEnemigo = HabilidadesEnemigos::getHabilidadesByNombre($enemigo->getNombre());
$defPersonaje = Estadisticas::getEstadisticasByPersonaje($_SESSION['idPersonaje']);
$defPersonaje = $defPersonaje->getDef();

if($_POST['habilidad'] < 5 && $_POST['habilidad'] != 0){
    for ($i=0; $i < count($habilidadesEnemigo); $i++) { 
        if($habilidadesEnemigo[$i]->getTurno() == $_POST['habilidad']){
            $arrayHabilidades = [
                "nombreEnemigo" => $habilidadesEnemigo[$i]->getNombreEnemigo(),
                "nombreHabilidad" => $habilidadesEnemigo[$i]->getNombreHabilidad(),
                "dmg" => $habilidadesEnemigo[$i]->getDmg(),
                "turno" => $habilidadesEnemigo[$i]->getTurno(),
                "def" => $defPersonaje,
                "atkEnemigo" => $enemigo->getAtk()
            ];
    
        }
    }
}else{
    $arrayHabilidades = [
        "nombreEnemigo" => $enemigo->getNombre(),
        "nombreHabilidad" => 0,
        "dmg" => $enemigo->getAtk(),
        "def" => $defPersonaje,
    ];
}

echo json_encode($arrayHabilidades);
?>