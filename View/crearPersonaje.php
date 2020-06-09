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

        $("#velocidad").html(datosClase.velocidad);
        $("#velocidadInput").val(datosClase.velocidad);

        $("#pm").html(datosClase.pm);
        $("#pmInput").val(datosClase.pm);

        $("#ph").html(datosClase.ph);
        $("#phInput").val(datosClase.ph);
    },
    error:function(){
        $(".descripcionClases").html("Lo sentimos, aún no está disponible.");
    }
    });
}
</script>
<body>
<header>
    <div class="container">
        <a href="../Controller/c.guardarUsuario.php"><img src="../View/img/logo.png" alt="Logo de ivalice" /></a>
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
        <!-- Botón para volver a la página principal -->
        <form action="../Controller/c.guardarUsuario.php">
            <input type="submit" value="Volver a la página principal" class="btn">
        </form>

        <!-- Botón listado de personajes -->
        <form action="../Controller/c.listarPersonajes.php">
            <input type="submit" value="Listado de personajes" class="btn">
        </form>
    </div>

    <!-- Oro que actualmente tiene al jugador -->
    <div class="oro">
        <img src="../View/img/money.png" alt="Tus puntos">&nbsp;&nbsp;<span><?= $data['usuarioActual']->getPts() ?></span>
    </div>
</header>
    <form action="../Controller/c.crearPersonaje.php" method="post" class="formulario" enctype="multipart/form-data">
        <div class="informacionFormulario">
            <!-- Input del nombre del personaje -->
            <div class="inputs">
                <label>Nombre de tu personaje: </label><input type="text" name="nombrePersonaje" id="nombrePersonaje" class="btn" palceholder="Nombre de tu personaje" required>
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
                <h4 class="tituloStats">Estadísticas iniciales</h4>
                <img src='../View/img/stats/vida1.png' alt="Stat de vida"> &nbsp; <span id="vida"></span>
                <input type="hidden" name="vida" id="vidaInput">
                <br>
                <img src="../View/img/stats/atk1.png" alt="Stat de ataque"> &nbsp; <span id="atk"></span>
                <input type="hidden" name="atk" id="atkInput">
                <br>
                <img src="../View/img/stats/def1.png" alt="Stat de defensa"> &nbsp; <span id="def"></span>
                <input type="hidden" name="def" id="defInput">
                <br>
                <img src="../View/img/stats/magia1.png" alt="Stat de magia"> &nbsp; <span id="magia"></span>
                <input type="hidden" name="magia" id="magiaInput">
                <br>
                <img src="../View/img/stats/vel.png" alt="Stat de velocidad"> &nbsp; <span id="velocidad"></span>
                <input type="hidden" name="velocidad" id="velocidadInput">
                <br>
                <br>
                <span class="pm">PM: </span> <span id="pm"></span>
                <input type="hidden" name="pm" id="pmInput">
                <br>
                <span class="ph">PH: </span> <span id="ph"></span>
                <input type="hidden" name="ph" id="phInput">
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
