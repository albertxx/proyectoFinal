<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/combate.css">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <script src="../jquery-3.4.1.js"></script>
    <style>
        body{
        background-image: url('<?= $carpetaMisiones.$data['mision']->getFoto().".jpg" ?>');
        background-repeat: no-repeat;
        background-size: cover;
        }
    </style>

    <title>INSERTAR AQUÍ MISIÓN</title>
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
        },
        error:function(){
            $(".contenedorStats").html("Lo sentimos, aún no está disponible.");
        }
        });

        if($(".ventanaModal").css("visibility") == "hidden"){
            $(".ventanaModal").css("visibility", "visible");
            $(".ventanaModalHabilidades").css("visibility", "hidden");
        }else{
            $(".ventanaModal").css("visibility", "hidden");
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
            var datosHabilidades = JSON.parse(data)
            $("#nombrePersonajeHabilidades").html(datosHabilidades[datosHabilidades.length-1].nombre_personaje);
            $("#tabla").html("");
            for (let i = 0; i < datosHabilidades.length-1; i++) {
                if(datosHabilidades[datosHabilidades.length-1].nivelPersonaje >= datosHabilidades[i].nivel_requerido){
                    $("#tabla").append("<tr class='habilidad'><td class='nombreHabilidad'>" + datosHabilidades[i].nombre + ":</td><td class='descripcionHabilidad'>" + datosHabilidades[i].descripcion + "</td></tr>");
                    console.log(datosHabilidades[datosHabilidades.length-1].nivelPersonaje);
                    console.log(datosHabilidades[i].nivel_requerido);
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
        }else{
            $(".ventanaModalHabilidades").css("visibility", "hidden");
        }
    }
</script>
<body>

    <!-- Contenedor que contendrá la información del enemigo -->
    <div class="containerEnemigo">
        <div class="enemigo"></div>
        <p class="vida">
            <img src="../View/img/stats/vida.png" alt=""> 
            100 / 100
        </p>
    </div>

    
    <!-- Contenedor que contendrá el menú de combate del jugador -->
    <div class="menuJugador">
        <div class="personaje">
            
            <p class="vida">
                <img src="../View/img/stats/vida.png" alt="" height="10" width="10"> 
                100 / <?= $data['estadisticas']->getVida() ?>
            </p>
            <img src="<?= $carpetaPersonajes.$data['personajeSeleccionado']->getFoto() ?>" alt="">
        </div>

        <div class="datosPersonaje">
            <div class="stats">
                <button class="btnStats" onclick="abrirVentanaEstadisticas(<?= $data['personajeSeleccionado']->getIdPersonaje() ?>)">Ver estadísticas</button>
                <p class="pm">100 / <?= $data['estadisticas']->getPm() ?></p>
                <p class="ph">100 / <?= $data['estadisticas']->getPh() ?></p>
            </div>

            <div class="textoCombate">
                <span id="textoCombate"></span>
            </div>
        </div>

        <div class="menuCombate">
            <div class="habilidades">
                <button class="botones" onclick="abrirVentanaHabilidades(<?= $data['personajeSeleccionado']->getIdPersonaje() ?>, <?= $data['personajeSeleccionado']->getIdClase() ?>)">
                    Habilidades
                </button>
            </div>

            <div class="ataqueNormal">
                <button class="botones">
                    Ataque normal
                </button>
            </div>

            <div class="defender">
                <button class="botones">
                    Defenderse
                </button>
            </div>
        </div>
    </div>
    <!-- Inicio ventana modal -->
    <div class="ventanaModal">

        <div class="encabezadoVentana">
            <h3 id="nombrePersonaje"></h3>
        </div>

<!-- Inicio ventana modal de las estadísticas -->
<div class="contenedorStats">
    <div class="stats">
        <img src='../View/img/stats/vida1.png'><span class="textoStat">Vida:</span>
        <span id="vida"></span>
    </div>

    <div class="stats">
        <img src='../View/img/stats/atk1.png'><span class="textoStat">Ataque:</span>
        <span id="atk"></span>
    </div>

    <div class="stats">
        <img src='../View/img/stats/def1.png'><span class="textoStat">Defensa:</span>
        <span id="def"></span>
    </div>

    <div class="stats">
        <img src='../View/img/stats/magia1.png'><span class="textoStat">Magia:</span>
        <span id="magia"></span>
    </div>
    
    <div class="stats">
        <img src='../View/img/stats/vel.png'><span class="textoStat">Velocidad:</span>
        <span id="velocidad"></span>
    </div>

    <div class="stats">
        <span class="pm textoStat">Puntos de magia (PM): </span> 
        <span id="pm"></span>
    </div>
    <div class="stats">
        <span class="ph texto stat">Puntos de habilidad (PH): </span> 
        <span id="ph"></span>
    </div>
</div>
<!-- Fin ventana modal estadísticas -->

<!-- Inicio ventana modal Habilidades -->
<div class="ventanaModalHabilidades">
    
    <div class="encabezadoVentana">
        <h3 id="nombrePersonajeHabilidades"></h3>
    </div>
    
    <div class="contenedorHabilidades">
        <table border="2" id="tabla"></table>
    </div>

</div>
<!-- Fin ventana modal habilidades -->
</body>
</html>