<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/20bcd05352.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../View/css/paginaPrincipal.css">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <script src="../jquery-3.4.1.js"></script>
    <title>Ivalice</title>
</head>

<script>
    function seleccionarPersonaje(nick, idMision){
        jQuery.ajax({
        url: "../Controller/c.listarPersonajes.php",
        data:'nick='+nick,
        type: "POST",
        timeout: 5000,
        success:function(data){
            var datosPersonaje = JSON.parse(data);
            $("#menuPersonajes").html("");
            $("#idMision").val(idMision);
            for (let i = 0; i < datosPersonaje.length; i++) {
                $("#menuPersonajes").append("<option value='" + datosPersonaje[i].idPersonaje + "'>" + datosPersonaje[i].nombre +"</option>");
                
            }
        },
        error:function(){
            $(".ventanaModal").html("Lo sentimos, aún no está disponible.");
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
    <!-- Header de la página -->
    <header>
        <div class="container">
            <img src="../View/img/logo.png"/>
            <p class="textoInicial">Bienvenido a Ivalice, 
                <span>
                    <form action="../Controller/c.modificarUsuario.php" method="post">
                        <input type="submit" class="btnUsuario" value="<?= $data['usuario']->getNick() ?>">
                    </form>
                    <form class="cerrarSesion" action="../Controller/c.cerrarSesion.php" method="post">
                        <input type="submit" value="Cerrar sesión" class="btnUsuario">
                    </form>
                </span> 
            </p>
        </div>

        <!-- Botones para navegar por las diferentes páginas de la app -->
        <div class="formularios">
            <!-- Botón crear personaje -->
            <form action="../Controller/c.crearPersonaje.php">
                <input type="hidden" name="usuario" value="<?= $data['usuario']->getNick() ?>">
                <input type="submit" value="Crear personaje" class="btn">
            </form>

            <!-- Botón listado de personajes -->
            <form action="../Controller/c.listarPersonajes.php">
                <input type="submit" value="Listado de personajes" class="btn">
            </form>
        </div>

        <!-- Oro que actualmente tiene al jugador -->
        <div class="oro">
            <img src="../View/img/money.png" alt="Tu oro">&nbsp;&nbsp;<span><?= $data['usuario']->getPts() ?></span>
        </div>
    </header>


    <!-- Inicio ventana modal de selección de personaje para la misión -->
    <div class="ventanaModal">
        <div class="encabezadoVentanaModal">
            <span>¿Con qué personaje irás a la misión?</span>
            <img src="../View/img/cancelar.png" alt="" onclick="seleccionarPersonaje()" class="cancelar">
        </div>
        <form action="../Controller/c.paginaHistoria.php" method="post">
            <select name="menuPersonajes" id="menuPersonajes" class="menuPersonajes"></select>
            <input type="hidden" name="idMision" id="idMision">
            <button type="submit" name="confirmar" class="btnAzul">Confirmar</button>
        </form>
    </div>
    <!-- Fin de la ventana modal de selección de personaje para la misión -->


    <!-- Misiones a realizar -->
    <div class="misiones">
    <h1 class="tituloMision">TUTORIAL</h1>
    <h1 class="tituloMision">HISTORIA</h1>

    <?php 
    
    for ($i=0; $i < count($data['misiones']); $i++) { 
    
    ?>

        <div class="mision">
            <div class="containerMision">
                <img src="<?= $carpetaMisiones.$data['misiones'][$i]->getFoto().".png" ?>" alt="" class="imagenesMisiones">
                
                <?php 

                    if($data['usuario']->getPts() >= $data['misiones'][$i]->getPts_requeridos()){
                ?>

                <button class="btn" onclick="seleccionarPersonaje('<?= $data['usuario']->getNick() ?>', <?= $data['misiones'][$i]->getIdMision() ?>)">
                    Realizar misión
                </button>

                <?php
                    }else{
                ?>
                        <button class="btn" disabled>
                            BLOQUEADO
                        </button>
                <?php
                    }

                ?>
            </div>

            <div class="info">
                <p>NOMBRE AVENTURA:</p>
                <p>Coste:</p>
                <p class="dificultad">Dificultad:
            <?php
                for ($j=1; $j <= $data['misiones'][$i]->getDificultad(); $j++) { 
                
            ?>
                <img src="../View/img/estrella.png" alt="">
            <?php
                }   
            ?>
                </p>
            </div>
        </div>
    <?php
    }
    ?>
</body>
</html>