<?php
sleep(1);
require_once "../Model/Misiones.php";
require_once "../Model/Enemigos.php";
require_once "../Model/Estadisticas.php";

$idMision = $_POST['idMision'];
$idPersonaje = $_POST['idPersonaje'];

$enemigo = Enemigos::getEnemigoByIdMision($idMision);
$estadisticasPersonaje = Estadisticas::getEstadisticasByPersonaje($idPersonaje);

$velocidadEnemigo = $enemigo->getVelocidad();
$velocidadPersonaje = $estadisticasPersonaje->getVelocidad();
$pmMaximo = $estadisticasPersonaje->getPm();
$phMaximo = $estadisticasPersonaje->getPh();

$vidaEnemigo = $enemigo->getVida();
$vidaPersonaje = $estadisticasPersonaje->getVida();

if($velocidadEnemigo > $velocidadPersonaje){
    echo "true ".$vidaEnemigo." ".$vidaPersonaje." ".$pmMaximo." ".$phMaximo;
}else{
    echo "false ".$vidaEnemigo." ".$vidaPersonaje." ".$pmMaximo." ".$phMaximo;
}
?>