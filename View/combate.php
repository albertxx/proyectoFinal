<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/combate.css">

    <style>
        body{
        background-image: url('<?= $carpetaMisiones.$data['mision']->getFoto().".jpg" ?>');
        background-repeat: no-repeat;
        background-size: cover;
        }
    </style>

    <title>INSERTAR AQUÍ MISIÓN</title>
</head>

<body>

    <!-- Contenedor que contendrá la información del enemigo -->
    <div class="containerEnemigo">
        <div class="enemigo"></div>
    </div>

    <!-- Contenedor que contendrá el menú de combate del jugador -->
    <div class="menuJugador">
        <div class="personaje">
            <p>vidaRestante / <?= $data['estadisticas']->getVida() ?></p>
            <img src="<?= $carpetaPersonajes.$data['personajeSeleccionado']->getFoto() ?>" alt="">
        </div>

        <div class="datosPersonaje">
            <div class="stats">
                <button>Ver estadísticas</button>
                <p>PM restante / <?= $data['estadisticas']->getPm() ?></p>
                <p>PH restante / <?= $data['estadisticas']->getPh() ?></p>
            </div>

            <div class="textoCombate">
                <span id="textoCombate"></span>
            </div>
        </div>

        <div class="menuCombate">
            <div class="habilidades">
                <button class="botones">
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
</body>
</html>