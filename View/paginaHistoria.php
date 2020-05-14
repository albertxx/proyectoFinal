<!DOCTYPE html>
<html lang="en">
<head>
<style>

body{
    background-image: url('<?= $carpetaMisiones.$data['mision']->getFoto().".jpg" ?>');
    background-repeat: no-repeat;
    background-size: cover;
}

</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/paginaHistoria.css">
    <link rel="stylesheet" href="../View/css/paginaPrincipal.css">
    <title>INSERTAR AQUI NOMBRE MISION</title>
</head>
<body>
    <div class="contenedorPrincipal">
        <div class="marcoHistoria"></div>
        <form action="" method="post">
            <input type="submit" value="Continuar" class="btnAzul">
            <input type="hidden" name="idPersonaje" value="<?= $idPersonaje ?>">
        </form>
    </div>
</body>
</html>