<?php 

require_once "../Model/Personaje.php";
$personaje = Personaje::getPersonajeById($_POST['idPersonaje']);
$personaje->borrarPersonaje();
header("Location: ../Controller/c.listarPersonajes.php");
?>