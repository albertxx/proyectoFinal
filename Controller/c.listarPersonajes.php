<?php 

require_once "../Model/Usuario.php";
require_once "../Model/IvaliceBD.php";
require_once "../Model/Clases.php";
require_once "../Model/Personaje.php";
require_once "../Model/Estadisticas.php";

if(!isset($_COOKIE['usuario']) || $_COOKIE['usuario'] == ""){
    require_once "../View/login.html";
}else{
    if(!isset($_REQUEST['nick'])){
        $nick = unserialize($_COOKIE['usuario'])->getNick();
        $carpetaFotosPersonaje = "../View/img/fotosPersonaje/";
        $data['usuarioActual'] = Usuario::getUsuarioById($nick);
    
        $data['personajes'] = Personaje::getPersonajesByNick($nick);
        require_once "../View/listadoPersonajes.php";
    }else{
        $nick = $_REQUEST['nick'];
        $personajes = Personaje::getPersonajesByNick($nick);
        for ($i=0; $i < count($personajes); $i++) { 
    
            $arrayPersonajes[] = [
                "idPersonaje" => $personajes[$i]->getIdPersonaje(),
                "nombre" => $personajes[$i]->getNombre(),
                "idClase" => $personajes[$i]->getIdClase(),
                "nivel" => $personajes[$i]->getNivel(),
                "foto" => $personajes[$i]->getFoto(),
                "xp" => $personajes[$i]->getXp(),
                "nick_usuario" => $personajes[$i]->getNick_usuario()
            ];
        }
        
        echo json_encode($arrayPersonajes);
    }
}

?>