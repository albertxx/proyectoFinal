<?php 
require_once "../Model/Usuario.php";
$nick = unserialize($_COOKIE['usuario'])->getNick();
$data['datosUsuario'] = Usuario::getUsuarioById($nick);
// Una vez introducido los datos del usuario modificado
if(isset($_REQUEST['nick'])){
    $usuarioModificado = new Usuario($_REQUEST['nick'], $_REQUEST['pwd'], $_REQUEST['nombre'], $_REQUEST['apellidos'], $_REQUEST['email'], $data['datosUsuario']->getPts());
    $usuarioModificado->modificarUsuario($data['datosUsuario']->getNick());
    setcookie('usuario', serialize($usuarioModificado), time()+60*60*24*30);
    header("Location: ../Controller/c.modificarUsuario.php");
}

require_once "../View/modificarUsuario.php";
?>