<?php 

require_once "../Model/Usuario.php";
require_once "../Model/IvaliceBD.php";
require_once "../Model/Clases.php";
require_once "../Model/Personaje.php";

if(!isset($_COOKIE['usuario']) || $_COOKIE['usuario'] == ""){
    require_once "../View/login.html";

}else{
    $nick = unserialize($_COOKIE['usuario'])->getNick();
    $data['usuarioActual'] = Usuario::getUsuarioById($nick);
    $data['clases'] = Clase::getClases();

    if(isset($_POST['nombrePersonaje'])){
        // Datos del personaje e inserción del mismo en la BD
        $carpeta_imagenes = $_SERVER['DOCUMENT_ROOT'] . "/Proyectos/proyectoFinal/View/img/fotosPersonaje/";
        $nombre_imagen = $_FILES['fotoPersonaje']['name'];
        $nombrePersonaje = $_POST['nombrePersonaje'];
        $idClase = $_POST['clases'];

        move_uploaded_file($_FILES['fotoPersonaje']['tmp_name'],$carpeta_imagenes.$nombre_imagen);

        $nuevoPersonaje = new Personaje(null, $nombrePersonaje, $idClase, 1, $nombre_imagen, 0, $nick);
        $vida = $_POST['vida'];
        $atk = $_POST['atk'];
        $def = $_POST['def'];
        $magia = $_POST['magia'];
        $velocidad = $_POST['velocidad'];
        $pm = $_POST['pm'];
        $ph = $_POST['ph'];
        $nuevoPersonaje->insertarPersonaje($vida, $atk, $def, $magia, $velocidad, $pm, $ph);
    }

    require_once "../View/crearPersonaje.php";
}
?>