<?php 

require_once "../Model/Clases.php";
if($_POST['idClase'] != ""){
    $clase = Clase::getClaseById($_POST['idClase']);
    $descripcionClase = $clase->getDescripcion();
    echo $descripcionClase;
}

?>