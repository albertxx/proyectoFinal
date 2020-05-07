<?php 

setcookie('usuario', "", time()+60*60*24);
header("Location: ../Controller/index.php");
?>