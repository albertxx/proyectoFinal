<?php 

require_once "../Model/Personaje.php";
require_once "../Model/Estadisticas.php";
require_once "../Model/Habilidades.php";
require_once "../Model/Misiones.php";
require_once "../Model/Enemigos.php";

session_start();

$carpetaMisiones = "../View/img/misiones/";
$carpetaPersonajes = "../View/img/fotosPersonaje/";
$carpetaEnemigos = "../View/img/enemigos/";
if(!isset($_COOKIE['usuario']) || $_COOKIE['usuario'] == ""){
    require_once "../View/login.html";
}else{
    $data['personajeSeleccionado'] = Personaje::getPersonajeById($_POST['idPersonaje']);
    $data['estadisticas'] = Estadisticas::getEstadisticasByPersonaje($_POST['idPersonaje']);
    $data['mision'] = Misiones::getMisionById($_POST['idMision']);
    $data['enemigo'] = Enemigos::getEnemigoByIdMision($_POST['idMision']);


    if(!isset($_SESSION['idMision'])){
        $_SESSION['idMision'] = $_POST['idMision'];
    }

    if(isset($_POST['idPersonaje'])){
        $_SESSION['idPersonaje'] = $_POST['idPersonaje'];
    }
    require_once "../View/combate.php";
}
?>