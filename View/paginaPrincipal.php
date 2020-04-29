<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/20bcd05352.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../View/css/paginaPrincipal.css">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <title>Ivalice</title>
</head>
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
            <img src="../View/img/money.png" alt="Tu oro">&nbsp;&nbsp;<span><?= $data['usuario']->getOro() ?></span>
        </div>
    </header>

    <!-- Misiones a realizar -->
    <div class="misiones">
    <h1 class="tituloMision">TUTORIAL</h1>
    <h1 class="tituloMision">HISTORIA</h1>
    <!-- PRIMERA MISION -->
        <div class="mision">
            <img src="../View/img/misiones/mision 1.png" alt="" class="imagenesMisiones">
            <div class="info">
                <p>NOMBRE AVENTURA</p>
                <p>Coste:</p>
                <p>Dificultad: </p>
            </div>
        </div>

    <!-- SEGUNDA MISION -->
        <div class="mision">
            <img src="../View/img/misiones/mision 2.png" alt="" class="imagenesMisiones">
            <div class="info">
                <p>NOMBRE AVENTURA</p>
                <p>Coste</p>
                <p>Dificultad: </p>
            </div>
        </div>

    <!-- TERCERA MISION -->
        <div class="mision">
            <img src="../View/img/misiones/mision 3.png" alt="" class="imagenesMisiones">
            <div class="info">
                <p>NOMBRE AVENTURA</p>
                <p>Coste</p>
                <p>Dificultad: </p>
            </div>
        </div>

    <!-- CUARTA MISION -->
        <div class="mision">
            <img src="../View/img/misiones/mision 4.png" alt="" class="imagenesMisiones">
            <div class="info">
                <p>NOMBRE AVENTURA</p>
                <p>Coste</p>
                <p>Dificultad: </p>
            </div>
        </div>

    <!-- QUINTA MISION -->
        <div class="mision">
            <img src="../View/img/misiones/mision 5.png" alt="" class="imagenesMisiones">
            <div class="info">
                <p>NOMBRE AVENTURA</p>
                <p>Coste</p>
                <p>Dificultad: </p>
            </div>
        </div>
    </div>
</body>
</html>