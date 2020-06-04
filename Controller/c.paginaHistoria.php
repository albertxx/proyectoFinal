<?php 
header("Content-Type: text/html;charset=utf-8");
require_once "../Model/Misiones.php";
require_once "../Model/Personaje.php";
$carpetaMisiones = "../View/img/misiones/";

if(!isset($_COOKIE['usuario']) || $_COOKIE['usuario'] == ""){
    require_once "../View/login.html";
}else{
    $idMision = $_POST['idMision'];
    $idPersonaje = $_POST['menuPersonajes'];
    $data['mision'] = Misiones::getMisionById($idMision);
    
    require_once "../View/paginaHistoria.php";
}
?>