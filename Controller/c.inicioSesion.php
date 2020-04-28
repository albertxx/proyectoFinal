<?php

require_once "../Model/Usuario.php";
require_once "../Model/IvaliceBD.php";

$data['usuarios'] = Usuario::getUsuarios();
$nick = $_POST['nick'];
$pwd = $_POST['pwd'];


foreach ($data['usuarios'] as $usuario) {
    if($usuario->getNick() == $nick && $usuario->getPwd() == $pwd){
        $usuario = [
            "nick" => $usuario->getNick(),
            "pwd" => $usuario->getPwd()
        ];

        echo json_encode($usuario);
    }else{
        echo false;
    }
}

?>