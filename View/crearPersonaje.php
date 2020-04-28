<?php 

require_once "../Model/Usuario.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/crearPersonaje.css">
    <script src="../jquery-3.4.1.js"></script>
    <title>Crear personaje</title>
</head>

<script>
    $("#clases").ready(mostrarDescripcion);

    function mostrarDescripcion() {
    jQuery.ajax({
    url: "../Controller/c.descripcionClase.php",
    data:'idClase='+$("#clases").val(),
    type: "POST",
    timeout: 5000,
    success:function(data){
        $(".descripcionClases").html(data).css("border", "2px solid rgb(228, 18, 165)");
    },
    error:function(){
        
    }
    });
}
</script>

<body>
<header>
    <div class="container">
        <img src="../View/img/logo.png"/>
        <span class="textoInicial">Bienvenido a Ivalice, 
            <p>
                <form action="../Controller/c.modificarUsuario.php" method="post">
                    <input type="submit" class="btnUsuario" value="<?= $data['usuarioActual']->getNick() ?>">
                </form>
            </p> 
        </p>
    </div>

        <!-- Botones para navegar por las diferentes páginas de la app -->
    <div class="formularios">
        <!-- Botón crear personaje -->
        <form action="../Controller/c.guardarUsuario.php">
            <input type="submit" value="Volver a la página principal" class="btn">
        </form>

        <!-- Botón listado de personajes -->
        <form action="">
            <input type="submit" value="Listado de personajes" class="btn">
        </form>
    </div>

    <!-- Oro que actualmente tiene al jugador -->
    <div class="oro">
        <img src="../View/img/money.png" alt="Tu oro">&nbsp;&nbsp;<span><?= $data['usuarioActual']->getOro() ?></span>
    </div>
</header>
    <form action="" method="post" class="formulario">
        <div class="informacionFormulario">
            <div class="inputNombre">
                <label>Nombre de tu personaje: </label><input type="text" name="btn" id="btn" class="btn" palceholder="Nombre de tu personaje">
            </div>

            <select name="clases" id="clases" onclick="mostrarDescripcion()">
            <?php 
                for ($i=0; $i < count($data['clases']); $i++) { 
                    
            ?>
                <option value="<?= $data['clases'][$i]->getId() ?>">
                    <?= $data['clases'][$i]->getNombre_clase() ?>
                </option>
            <?php
                }
            ?>
            </select>
        </div>

        <div class="descripcionClases">
            
        </div>
        <!-- <input type="submit" value="Enviar" class="btnSubmit"> -->
    </form>
</body>
</html>
