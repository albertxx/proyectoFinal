<?php 

require_once "../Model/Usuario.php";
$usuarioNuevo = new Usuario($_REQUEST['registroNick'], $_REQUEST['pwd'], $_REQUEST['nombre'], $_REQUEST['apellidos'], $_REQUEST['correo']);
var_export($usuarioNuevo);
$usuarioNuevo->registarUsuario();
header("Location: ../Controller/c.guardarUsuario.php?nick=".$_REQUEST['registroNick']);
?>