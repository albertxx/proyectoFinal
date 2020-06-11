<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <link rel="stylesheet" href="../View/css/paginaPrincipal.css">
    <link rel="stylesheet" href="../View/css/listadoPersonajes.css">
    <script src="../jquery-3.4.1.js"></script>
    <title>Lista de personajes</title>
</head>

<script>
    // Función para abrir la ventana modal de las estadísticas
    function abrirVentanaEstadisticas(idPersonaje) {
        jQuery.ajax({
        url: "../Controller/c.estadisticasPersonaje.php",
        data:'idPersonaje='+idPersonaje,
        type: "POST",
        timeout: 5000,
        success:function(data){
            var datosPersonaje = JSON.parse(data);
            $("#nombrePersonaje").html(datosPersonaje.nombre_personaje);
            $("#vida").html(datosPersonaje.vida);
            $("#atk").html(datosPersonaje.atk);
            $("#def").html(datosPersonaje.def);
            $("#magia").html(datosPersonaje.magia);
            $("#velocidad").html(datosPersonaje.velocidad);
            $("#pm").html(datosPersonaje.pm);
            $("#ph").html(datosPersonaje.ph);
            $("#xpNecesaria").html(datosPersonaje.xp);
        },
        error:function(){
            $(".contenedorStats").html("Lo sentimos, aún no está disponible.");
        }
        });

        if($(".ventanaModal").css("visibility") == "hidden"){
            $(".ventanaModal").css("visibility", "visible");
            $(".ventanaModalHabilidades").css("visibility", "hidden");
            $("#ventanaAyuda").css("visibility", "hidden");
        }else{
            $(".ventanaModal").css("visibility", "hidden");
        }
    }

    // Función para abrir la ventana de ayuda
    function abrirAyuda() { 
        if($("#ventanaAyuda").css("visibility") == "hidden"){
            $("#ventanaAyuda").css("visibility", "visible");
            $(".ventanaModal").css("visibility", "hidden");
            $(".ventanaModalHabilidades").css("visibility", "hidden");
        }else{
            $("#ventanaAyuda").css("visibility", "hidden");
        }
    }

    // Función para abrir la ventana modal de las habilidades
    function abrirVentanaHabilidades(idPersonaje, idClase) {
        var params = {
                idPersonaje: idPersonaje,
                idClase: idClase
            };

        jQuery.ajax({
        url: "../Controller/c.habilidadesPersonaje.php",
        data:params,
        type: "POST",
        timeout: 5000,
        success:function(data){
            console.log(data);
            var datosHabilidades = JSON.parse(data)
            $("#nombrePersonajeHabilidades").html(datosHabilidades[datosHabilidades.length-1].nombre_personaje);
            $("#tabla").html("");
            for (let i = 0; i < datosHabilidades.length-1; i++) {
                if(parseInt(datosHabilidades[datosHabilidades.length-1].nivelPersonaje) < parseInt(datosHabilidades[i].nivel_requerido)){
                    $("#tabla").append("<tr class='habilidad'><td class='nombreHabilidad'><img src='../View/img/bloq.png' alt='bloqueado'>" + datosHabilidades[i].nombre + ":</td><td class='descripcionHabilidad'>" + datosHabilidades[i].descripcion + "</td><td class='pm'>" + datosHabilidades[i].costePm + "</td><td class='ph'>" + datosHabilidades[i].costePh + "</td></tr>");
                }else{
                    $("#tabla").append("<tr class='habilidad'><td class='nombreHabilidad'>" + datosHabilidades[i].nombre + ":</td><td class='descripcionHabilidad'>" + datosHabilidades[i].descripcion + "</td><td class='pm'>" + datosHabilidades[i].costePm + "</td><td class='ph'>" + datosHabilidades[i].costePh + "</td></tr>");
                }
            }

            
        },
        error:function(){
            $(".contenedorHabilidades").html("Lo sentimos, aún no está disponible.");
        }
        });

        if($(".ventanaModalHabilidades").css("visibility") == "hidden"){
            $(".ventanaModalHabilidades").css("visibility", "visible");
            $(".ventanaModal").css("visibility", "hidden");
            $("#ventanaAyuda").css("visibility", "hidden");
        }else{
            $(".ventanaModalHabilidades").css("visibility", "hidden");
        }
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
        <!-- Botón crear personaje -->
        <form action="../Controller/c.crearPersonaje.php">
            <input type="submit" value="Crear personaje" class="btn">
        </form>

        <!-- Botón para volver a la página principal -->
        <form action="../Controller/c.guardarUsuario.php">
            <input type="submit" value="Volver a la página principal" class="btn">
        </form>

        <span>
            <button class="btn" onclick="abrirAyuda()">
                Ayuda
            </button>
        </span>
    </div>

    <!-- Oro que actualmente tiene al jugador -->
    <div class="oro">
        <img src="../View/img/money.png" alt="Tu oro">&nbsp;&nbsp;<span><?= $data['usuarioActual']->getPts() ?></span>
    </div>
</header>


<div class="listaPersonajes">
<!-- Inicio ventana modal -->
<div class="ventanaModal">

    <div class="encabezadoVentanaAyuda">
        <h3 id="nombrePersonaje"></h3>
        <img src="../View/img/cancelar.png" alt="" onclick="abrirVentanaEstadisticas()">
    </div>

    <!-- Inicio ventana modal de las estadísticas -->
    <div class="contenedorStats">
        <div class="stats">
            <img src='../View/img/stats/vida1.png' alt="Stat de vida"><span class="textoStat">Vida:</span>
            <span id="vida"></span>
        </div>

        <div class="stats">
            <img src='../View/img/stats/atk1.png' alt="Stat de ataque"><span class="textoStat">Ataque:</span>
            <span id="atk"></span>
        </div>

        <div class="stats">
            <img src='../View/img/stats/def1.png' alt="Stat de defensa"><span class="textoStat">Defensa:</span>
            <span id="def"></span>
        </div>

        <div class="stats">
            <img src='../View/img/stats/magia1.png' alt="Stat de magia"><span class="textoStat">Magia:</span>
            <span id="magia"></span>
        </div>
        
        <div class="stats">
            <img src='../View/img/stats/vel.png' alt="Stat de velocidad"><span class="textoStat">Velocidad:</span>
            <span id="velocidad"></span>
        </div>

        <div class="stats">
            <span class="pm textoStat">Puntos de magia (PM): </span> 
            <span id="pm"></span>
        </div>
        <div class="stats">
            <span class="ph textoStat">Puntos de habilidad (PH): </span> 
            <span id="ph"></span>
        </div>

        <div class="stats">
            <span class="textoStat">Siguiente nivel: </span>
            <span id="xpNecesaria"></span>
        </div>
    </div>
    <!-- Fin ventana modal de las estadísticas -->
</div>

<!-- Inicio ventana modal de las habilidades -->
<div class="ventanaModalHabilidades">
    
    <div class="encabezadoVentanaAyuda">
        <h3 id="nombrePersonajeHabilidades"></h3>
        <img src="../View/img/cancelar.png" alt="Cerrar ventana modal" title="Cerrar ventana modal" onclick="abrirVentanaHabilidades()">
    </div>
    
    <div class="contenedorHabilidades">
        <table border="2" id="tabla"></table>
    </div>

</div>
<!-- Fin ventana modal de las habilidades -->

<div class="ventanaModalAyuda" id="ventanaAyuda">
        <div class="encabezadoVentanaAyuda">
            <span>Información sobre la página de listado de personajes</span>
            <img src="../View/img/cancelar.png" alt="Cerrar ventana modal" title="Cerrar ventana modal" onclick="abrirAyuda()">
        </div>
        
        <div class="infoAyuda">
            <p>
                <b>¿Qué es la experiencia que se muestra junto a la imagen de mi personaje?</b> <br>
                Es la experiencia que actualmente tiene tu personaje en ese nivel. Cada vez que suba de nivel, la experiencia volverá a 0.
            </p>

            <p>
                <b>¿Dónde veo las estadísticas de mi personaje?</b> <br>
                Sólo tienes que pulsar el botón de "Ver todas las estadísticas" y las podrás ver. Ahí también encontrarás la experiencia total que tu personaje necesita para subir de nivel.
            </p>

            <p>
                <b>¿Cómo borro mi personaje?</b> <br>
                Sólo tienes que pulsar el botón que está debajo de la imagen de tu personaje, y automáticamente se borrará una vez lo pulses.
            </p>

            <p>
                <b>¿Qué significa el candado de las habilidades?</b> <br>
                Significa que aún no las has desbloqueado. Las habilidades suelen desbloquearse cada 5 niveles. (1, 5, 10...)
            </p>
            <b>Como siempre, desde esta página puedes volver a las demás páginas de la web.</b>
        </div>
</div>

<?php 

    for ($i=0; $i < count($data['personajes']); $i++) { 
?>
    <div class="personaje">
        
        <div class="container">
            <div class="fotoPersonaje">
                <img src="<?= $carpetaFotosPersonaje.$data['personajes'][$i]->getFoto() ?>" alt="<?= $data['personajes'][$i]->getNombre() ?>" class="imagenPersonaje">
            </div>
            
            <form action="../Controller/c.borrarPersonaje.php" method="post">
                <input type="submit" value="Borrar personaje" class="btnBorrar">
                <input type="hidden" name="idPersonaje" value=<?=  $data['personajes'][$i]->getIdPersonaje() ?>>
            </form>

        </div>

        <div class="infoPersonaje">
            <input type="hidden" name="idPersonaje" id="idPersonaje" value="<?= $data['personajes'][$i]->getIdPersonaje() ?>">
            <p><span>Nombre: </span> <?= $data['personajes'][$i]->getNombre() ?></p>
            <p><span>Clase:</span> <?= Clase::getClaseById($data['personajes'][$i]->getIdClase())->getNombre_clase() ?> </p> 
            <p><span>Experiencia: </span> <?= $data['personajes'][$i]->getXp() ?> </p>
            <p><span>Nivel: </span> <?= $data['personajes'][$i]->getNivel() ?> </p>
            <button class="btn" onclick="abrirVentanaHabilidades(<?= $data['personajes'][$i]->getIdPersonaje() ?>, <?= $data['personajes'][$i]->getIdClase() ?>)">
                Habilidades
            </button>
            <button class="btn" onclick="abrirVentanaEstadisticas(<?= $data['personajes'][$i]->getIdPersonaje() ?>)">
                Ver todas las estadísticas
            </button>
        </div>
    </div>
<?php
    }
?>
</div>

</body>
</html>