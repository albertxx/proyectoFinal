<?php 

require_once "../Model/Misiones.php";
require_once "../Model/Personaje.php";
$carpetaMisiones = "../View/img/misiones/";

if(!isset($_POST['idMision'])){
    require_once "../Controller/c.guardarUsuario.php";
}else{
    $data['mision'] = Misiones::getMisionById($_POST['idMision']);
    $idPersonaje = $_POST['menuPersonajes'];
    require_once "../View/paginaHistoria.php";
}
?>