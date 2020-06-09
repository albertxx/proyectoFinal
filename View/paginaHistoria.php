<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<style>

body{
    background-image: url('<?= $carpetaMisiones.$data['mision']->getFoto().".jpg" ?>');
    background-repeat: no-repeat;
    background-size: cover;
}

@media (max-width: 1200px){
    body{
        background-image: url('<?= $carpetaMisiones.$data['mision']->getFoto().".jpg" ?>');
        background-repeat: repeat-y;
        background-size: cover;
    }
}
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/paginaHistoria.css">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <title><?= $data['mision']->getNombreMision() ?></title>
</head>
<body>
    <div class="contenedorPrincipal">
        <?php if(!isset($_REQUEST['victoria'])){ ?>
            <div class="marcoHistoria"><?= $data['mision']->getPreHistoria() ?></div>
        <?php }else if(isset($_REQUEST['victoria']) && $_REQUEST['victoria'] == 0){ ?>
            <div class="marcoHistoria">
                <span>¡Perdiste, la próxima vez será!</span>
                <div class="recompensa">
                    <span><b>Puntos perdidos:</b><?php echo $data['mision']->getPts_ganados() / 2; ?> </span>
                </div>
            </div>
        <?php }else{ ?>
            <div class="marcoHistoria">
                <?= $data['mision']->getPostHistoria() ?>

                <div class="recompensa">
                    <span><b>Experiencia ganada:</b><?= $data['enemigo']->getExp() ?> </span>
                    <span><b>Puntos ganados:</b><?= $data['mision']->getPts_ganados() ?> </span>
                </div>
            </div>
        <?php } ?>


        <?php if(!isset($_REQUEST['victoria'])){ ?>
            <form action="../Controller/c.combate.php" method="post">
                <input type="submit" value="Continuar" class="btnNegro">
                <input type="hidden" name="idPersonaje" value="<?= $idPersonaje ?>">
                <input type="hidden" name="idMision" value="<?= $idMision ?>">
            </form>
        <?php }else{ ?>
            <form action="../Controller/c.guardarUsuario.php" method="post">
                <input type="submit" value="Continuar" class="btnNegro">
            </form>
        <?php } ?>
        
    </div>
</body>
</html>