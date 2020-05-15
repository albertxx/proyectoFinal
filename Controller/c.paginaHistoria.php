<?php 

require_once "../Model/Misiones.php";
require_once "../Model/Personaje.php";
$carpetaMisiones = "../View/img/misiones/";

if(!isset($_POST['idMision'])){
    require_once "../Controller/c.guardarUsuario.php";
}else{
    $idMision = $_POST['idMision'];
    $idPersonaje = $_POST['menuPersonajes'];
    $data['mision'] = Misiones::getMisionById($idMision);
    
    require_once "../View/paginaHistoria.php";
}
?>