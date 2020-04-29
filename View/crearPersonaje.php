<?php 

require_once "../Model/Usuario.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/crearPersonaje.css">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
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
        var datosClase = JSON.parse(data);
        $(".descripcionClases").html(datosClase.descripcion);
        $("#vida").html(datosClase.vida);
        $("#vidaInput").val(datosClase.vida);
        $("#atk").html(datosClase.atk);
        $("#atkInput").val(datosClase.atk);
        $("#def").html(datosClase.def);
        $("#defInput").val(datosClase.def);
        $("#magia").html(datosClase.magia);
        $("#magiaInput").val(datosClase.magia);
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
    <form action="../Controller/c.crearPersonaje.php" method="post" class="formulario" enctype="multipart/form-data">
        <div class="informacionFormulario">
            <!-- Input del nombre del personaje -->
            <div class="inputs">
                <label>Nombre de tu personaje: </label><input type="text" name="nombrePersonaje" id="nombrePersonaje" class="btn" palceholder="Nombre de tu personaje">
            </div>

            <!-- Selección de clases -->
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

            <!-- Input de la foto del personaje -->
            <div class="inputs">
                <span class="fotoPersonaje">
                    <input type="file" name="fotoPersonaje" id="fotoPersonaje">
                </span>
                
                <label for="fotoPersonaje" id="labelPersonaje">Añada una foto de su personaje.</label>
            </div>

        <input type="submit" value="Crear personaje" class="btnSubmit">
        </div>
        

        <!-- Bloque que contiene toda la información de la clase seleccionada -->
        <div class="infoClases">
            <div class="descripcionClases"></div>

            <br>
            <br>

            <div class="stats">
                <img src='../View/img/stats/vida1.png'> &nbsp; <span id="vida"></span>
                <input type="hidden" name="vida" id="vidaInput">
                <br>
                <img src="../View/img/stats/atk1.png" alt=""> &nbsp; <span id="atk"></span>
                <input type="hidden" name="atk" id="atkInput">
                <br>
                <img src="../View/img/stats/def1.png" alt=""> &nbsp; <span id="def"></span>
                <input type="hidden" name="def" id="defInput">
                <br>
                <img src="../View/img/stats/magia1.png" alt=""> &nbsp; <span id="magia"></span>
                <input type="hidden" name="magia" id="magiaInput">
            </div>
        </div>
    </form>

<script type="application/javascript">
    jQuery('input[type=file]').change(function(){
    var filename = jQuery(this).val().split('\\').pop();
    var idname = jQuery(this).attr('id');
    $("#labelPersonaje").html(filename);
    });
</script>
</body>
</html>
