<?php 
require_once "../Model/Misiones.php";
require_once "../Model/Estadisticas.php";
require_once "../Model/Personaje.php";
require_once "../Model/Enemigos.php";
require_once "../Model/Usuario.php";

$nick = unserialize($_COOKIE['usuario'])->getNick();
$usuario = Usuario::getUsuarioById($nick);

$carpetaMisiones = "../View/img/misiones/";
$data['mision'] = Misiones::getMisionById($_REQUEST['idMision']);
$data['enemigo'] = Enemigos::getEnemigoByIdMision($_REQUEST['idMision']);
$personaje = Personaje::getPersonajeById($_REQUEST['idPersonaje']);

if($_REQUEST['victoria'] == 1){
    $personaje->aumentarNivel($data['enemigo']->getExp());

    $usuario->ganarPuntos($data['mision']->getPts_ganados());
    $usuarioNuevo = Usuario::getUsuarioById($nick);
    setcookie('usuario', serialize($usuarioNuevo), time()+60*60*24*30);
}else{
    $puntosPerdidos = $data['mision']->getPts_ganados() / 2;
    $usuario->perderPuntos($puntosPerdidos);
    $usuarioNuevo = Usuario::getUsuarioById($nick);
    setcookie('usuario', serialize($usuarioNuevo), time()+60*60*24*30);
}
require_once "../View/paginaHistoria.php";
?>