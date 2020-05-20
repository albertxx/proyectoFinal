<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <script src="../jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="../View/css/modificarUsuario.css">
    <title>Ivalice</title>
</head>
<script>
    function comprobarUsuario() {
    $("#cargando").show();
    jQuery.ajax({
    url: "../Controller/c.comprobarRegistro.php",
    data:'nick='+$("#registroNick").val(),
    type: "POST",
    timeout: 5000,
    success:function(data){
        if(data == false){
            $("#estadoRegistro").html("Usuario no Disponible. Ya está siendo utilizado.").css("color", "red");
            $("#btnSubmit").attr('disabled', 'disabled');
        }else{
            $("#estadoRegistro").html("Usuario Disponible.").css("color", "lightgreen");
            $("#btnSubmit").removeAttr('disabled');
        }
        $("#cargando").hide();
    },
    error:function(){
        $("#error").html("Ups, parece que ha habido un error al registrarse. ¡Lo sentimos!");
    }
    });
}
</script>
<body>
    <header>
        <div class="container">
            <img src="../View/img/logo.png"/>
            <p class="textoInicial">Bienvenido a Ivalice, 
                <span>
                    <form action="../Controller/c.modificarUsuario.php" method="post">
                        <input type="submit" class="btnUsuario" value="<?= $data['datosUsuario']->getNick() ?>">
                    </form>
                </span> 
            </p>
        </div>

        <div class="formularios">
            <form action="../Controller/c.crearPersonaje.php">
                <input type="submit" value="Crear personaje" class="btn">
            </form>

            <form action="../Controller/c.guardarUsuario.php">
                <input type="submit" value="Volver a la página principal" class="btn">
            </form>

            <form action="../Controller/c.listarPersonajes.php">
                <input type="submit" value="Listado de personajes" class="btn">
            </form>
        </div>

        <div class="oro">
            <img src="../View/img/money.png" alt="Tu oro">&nbsp;&nbsp;<span><?= $data['datosUsuario']->getPts() ?></span>
        </div>
    </header>

    <h1>Modifica los campos que quieras cambiar.</h1>
    <div class="contenedor-formulario">
        <form action="../Controller/c.modificarUsuario.php" method="post" class="formulario">
            <input type="text" name="nick" class="btn" id="registroNick" value="<?= $data['datosUsuario']->getNick() ?>" onchange="comprobarUsuario()">
            <div id="estadoRegistro"></div>
            <input type="password" name="pwd" class="btn" value="<?= $data['datosUsuario']->getPwd() ?>" minlength="6" maxlength="18">
            <input type="text" name="nombre" class="btn" value="<?= $data['datosUsuario']->getNombre() ?>">
            <input type="text" name="apellidos" class="btn" value="<?= $data['datosUsuario']->getApellidos() ?>">
            <input type="text" name="email" class="btn" value="<?= $data['datosUsuario']->getCorreo() ?>">
            <div class="linea"></div>
            <input type="submit" value="Modificar datos" class="btnSubmit" id="btnSubmit">
        </form>
    </div>
    
</body>
</html>