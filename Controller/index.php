<?php 

if(!isset($_COOKIE['usuario'])){
    require_once "../View/login.html";
}else{
    require_once "../Controller/c.guardarUsuario.php";
}

?>