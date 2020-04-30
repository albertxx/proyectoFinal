<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <link rel="stylesheet" href="../View/css/crearPersonaje.css">
    <link rel="stylesheet" href="../View/css/listadoPersonajes.css">
    <script src="../jquery-3.4.1.js"></script>
    <title>Lista de personajes</title>
</head>

<script>
    function abrirVentana(idPersonaje) {
        jQuery.ajax({
        url: "../Controller/c.estadisticasPersonaje.php",
        data:'idPersonaje='+idPersonaje,
        type: "POST",
        timeout: 5000,
        success:function(data){
            var datosClase = JSON.parse(data);
            $("#vida").html(datosClase.vida);
            $("#atk").html(datosClase.atk);
            $("#def").html(datosClase.def);
            $("#magia").html(datosClase.magia);
            $("#pm").html(datosClase.pm);
            $("#ph").html(datosClase.ph);
        },
        error:function(){
            $(".contenedorStats").html("Lo sentimos, aún no está disponible.");
        }
        });

        if($(".ventanaModal").css("visibility") == "hidden"){
            $(".ventanaModal").css("visibility", "visible");
        }else{
            $(".ventanaModal").css("visibility", "hidden");
        }
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
        <form action="../Controller/c.crearPersonaje.php">
            <input type="submit" value="Crear personaje" class="btn">
        </form>

        <!-- Botón para volver a la página principal -->
        <form action="../Controller/c.guardarUsuario.php">
            <input type="submit" value="Volver a la página principal" class="btn">
        </form>
    </div>

    <!-- Oro que actualmente tiene al jugador -->
    <div class="oro">
        <img src="../View/img/money.png" alt="Tu oro">&nbsp;&nbsp;<span><?= $data['usuarioActual']->getOro() ?></span>
    </div>
</header>


<div class="listaPersonajes">

<div class="ventanaModal">
    <div class="contenedorStats">
        <div class="stats">
            <img src='../View/img/stats/vida1.png'>
            <span id="vida">VIDA</span>
        </div>

        <div class="stats">
            <img src='../View/img/stats/atk1.png'>
            <span id="atk">ATK</span>
        </div>

        <div class="stats">
            <img src='../View/img/stats/def1.png'>
            <span id="def">DEF</span>
        </div>

        <div class="stats">
            <img src='../View/img/stats/magia1.png'>
            <span id="magia">MAGIA</span>
        </div>
        
        <div class="stats">
            <span class="pm">PM: </span> 
            <span id="pm"></span>
        </div>

        <div class="stats">
            <span class="ph">PH: </span> 
            <span id="ph"></span>
        </div>
    </div>
</div>

<?php 

    for ($i=0; $i < count($data['personajes']); $i++) { 
?>
    <div class="personaje">
        
        <div class="fotoPersonaje">
            <img src="<?= $carpetaFotosPersonaje.$data['personajes'][$i]->getFoto() ?>" alt="" class="imagenPersonaje">
        </div>

        <div class="infoPersonaje">
            <input type="hidden" name="idPersonaje" id="idPersonaje" value="<?= $data['personajes'][$i]->getIdPersonaje() ?>">
            <p><span>Nombre: </span> <?= $data['personajes'][$i]->getNombre() ?></p>
            <p><span>Clase:</span> <?= Clase::getClaseById($data['personajes'][$i]->getIdClase())->getNombre_clase() ?> </p> 
            <p><span>Vida: </span> <?= Estadisticas::getEstadisticasByPersonaje($data['personajes'][$i]->getIdPersonaje())->getVida() ?> </p>
            <p><span>Nivel: </span> <?= $data['personajes'][$i]->getNivel() ?> </p>
            <p><span>Habilidades:</span></p>
            <br>
            <br>
            <button onclick="abrirVentana(<?= $data['personajes'][$i]->getIdPersonaje() ?>)">
                Ver todas las estadísticas <?= $data['personajes'][$i]->getIdPersonaje() ?>
            </button>
        </div>
    </div>
<?php
    }
?>
</div>

</body>
</html>