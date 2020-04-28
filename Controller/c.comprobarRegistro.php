<?php
require_once("../Model/IvaliceBD.php");
if($_POST['nick'] != "") {
  $conexion = IvaliceBD::connectDB();
  $consulta = $conexion->query("SELECT * FROM usuarios WHERE nick='".$_POST["nick"]."'");
  $filas = $consulta->rowCount();
  if($filas>0) {
      echo false;
  }else{
      echo true;
  }
}else{
  echo "vacio";
}
?>