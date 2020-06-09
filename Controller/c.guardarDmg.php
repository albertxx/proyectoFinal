<?php

require_once "../Model/Enemigos.php";

session_start();
$enemigo = Enemigos::getEnemigoByIdMision($_SESSION['idMision']);

?>