<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/css/combate.css">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <link rel="shortcut icon" href="../View/img/minilogo.jpg" />
    <meta http-equiv="Pragma" content="no-cache">
    <script src="../jquery-3.4.1.js"></script>
    <style>
        body{
        background-image: url('<?= $carpetaMisiones.$data['mision']->getFoto().".jpg" ?>');
        background-repeat: no-repeat;
        background-size: cover;
        }
    </style>

    <title><?= $data['mision']->getNombreMision() ?></title>
</head>
<script>

    // Función de una vez haya terminado la pelea
    function finBatalla() {
        $("#btnHabilidades").attr('disabled','disabled');
        $("#btnAtaqueNormal").attr('disabled','disabled');
        $("#btnDef").attr('disabled','disabled');
        $("#btnAbandonar").css("display", "none");
        $("#btnContinuar").css("display", "block");
    }

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
            var datosHabilidades = JSON.parse(data);
            
            $("#nombrePersonajeHabilidades").html(datosHabilidades[datosHabilidades.length-1].nombre_personaje);
            var nivelPersonaje = parseInt(datosHabilidades[datosHabilidades.length-1].nivelPersonaje);
            $("#tabla").html("");
            
            $("#tabla").html("<tr><th>Habilidad</th><th>Descripción</th><th>PM</th><th>PH</th></tr>");

            for (let i = 0; i <datosHabilidades.length-1; i++) {

                if(nivelPersonaje >= parseInt(datosHabilidades[i].nivel_requerido)){   
                    if(pmMaximo >= parseInt(datosHabilidades[i].costePm) && phMaximo >= parseInt(datosHabilidades[i].costePh)){
                        $("#tabla").append("<tr class='habilidad'><td class='nombreHabilidad'><button class='btnHabilidad' onclick='usarHabilidad(" + datosHabilidades[i].idHabilidad + ", " + datosHabilidades[datosHabilidades.length-1].idPersonaje +")'>" + datosHabilidades[i].nombre + ":</button></td><td class='descripcionHabilidad'>" + datosHabilidades[i].descripcion + "</td><td class='pm'>" + datosHabilidades[i].costePm + "</td><td class='ph'>" + datosHabilidades[i].costePh + "</td></tr>");
                    }else{
                        $("#tabla").append("<tr class='habilidad'><td class='nombreHabilidad'><button disabled class='btnHabilidad' onclick='usarHabilidad(" + datosHabilidades[i].idHabilidad + ", " + datosHabilidades[datosHabilidades.length-1].idPersonaje +")'>" + datosHabilidades[i].nombre + ":</button></td><td class='descripcionHabilidad'>" + datosHabilidades[i].descripcion + "</td><td class='pm'>" + datosHabilidades[i].costePm + "</td><td class='ph'>" + datosHabilidades[i].costePh + "</td></tr>");
                    }
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


// COMBATE

// Variables globales
var turno;
var id_Mision;
var vidaRestante = 0;
var vidaPersonaje = 0;
var turnosVeneno = 0;
var turnosBoost = 0;
var defenderse = false;
var pmMaximo = 0;
var phMaximo = 0;

// variables globales efecto de personaje al enemigo
var turnosVenenoPersonaje = 0;
var turnosBoostAtk = 0;
var turnosBoostAtk2 = 0;
var turnosBoostDef = 0;
var turnosBoostMagia = 0;
var turnosDormir = 0;
var turnosCeguera = 0;
var turnosQuemadura = 0;
var turnosCongelar = 0;
var aturdido = false;
var vecesAturdido = 0;

// Comprobar quién tiene el primer turno
    function comprobarTurno(idMision, idPersonaje) {
        
        var params = {
            idPersonaje: idPersonaje,
            idMision: idMision
        };

        jQuery.ajax({
        url: "../Controller/c.comprobarTurno.php",
        data:params,
        type: "POST",
        timeout: 5000,
        success:function(data){
            var resultado = data.split(" ");
            vidaRestante = parseInt(resultado[1]);
            vidaPersonaje = parseInt(resultado[2]);
            pmMaximo = parseInt(resultado[3]);
            phMaximo = parseInt(resultado[4]);

            turno = (resultado[0] == 'true');
            id_Mision = idMision;
            if(turno == true){
                turnoEnemigo(id_Mision);
            }
        
        },
        error:function(){
            $("#textoCombate").html("DB ERROR");
        }
        });

    }

    // Función de ataque enemigo
    function turnoEnemigo(idMision) {
        var habilidad = Math.round(Math.random()*8);
        // Efecto de veneno en caso de estar aplicado
        if(turnosVeneno > 0){
            turnosVeneno--;
            vidaPersonaje = vidaPersonaje - 5;
            $("#vidaPersonaje").html(vidaPersonaje);

        }

        if(turnosVeneno == 0){
             $("#venenoPersonaje").html("");
        }

        
        
        // Efecto de boost de ataque en caso de estar aplicado
        if(turnosBoost > 0){
            turnosBoost--;
        }

        if(turnosBoost == 0){
             $("#estadoEnemigo").html("");
        }
        var dmg = 0;
        var params = {
            habilidad: habilidad,
            idMision: idMision
        };

        jQuery.ajax({
        url: "../Controller/c.turnoEnemigo.php",
        data:params,
        type: "POST",
        timeout: 5000,
        success:function(data){
            var datosHabilidad = JSON.parse(data);
            
            if(turnosCeguera > 0){
                var cegado = Math.round(Math.random()*1);
                turnosCeguera--;
            }else{
                $("#cegueraEnemigo").html("");
            }

            dmg = parseInt(datosHabilidad.dmg);

            // En caso de que el enemigo no esté ni congelado ni dormido
            if(turnosCongelar <= 0 && turnosDormir <= 0 && aturdido == false){
                if(cegado == 0 || turnosCeguera <= 0){
                    // En caso de que haya usado una habilidad
                        if(datosHabilidad.nombreHabilidad != 0){

                            // En caso de que haya usado una habilidad que envene
                            if(datosHabilidad.dmg == 5){
                                $("#textoCombate").html(datosHabilidad.nombreEnemigo + " usó " + datosHabilidad.nombreHabilidad + " y causó veneno.");
                                
                                if(turnosVeneno == 0){
                                    turnosVeneno = 3;
                                    $("#venenoPersonaje").html("<img src='../View/img/estados/veneno.png' />");
                                }

                                
                                

                                // En caso de que haya hecho una habilidad de aumento de ataque
                            }else if(parseInt(datosHabilidad.dmg) == 0){
                                
                                $("#textoCombate").html(datosHabilidad.nombreEnemigo + " usó " + datosHabilidad.nombreHabilidad + " y aumentó su ataque.");
                                
                                if(turnosBoost == 0){
                                    turnosBoost = 3;
                                }

                                
                                $("#estadoEnemigo").append("<img src='../View/img/estados/boost_atk.png' />");
                                
                                // Habilidades sin efectos
                            }else{
                                // En caso de tener un boost de atk
                                if(turnosBoost > 0){
                                    var dmgRealizado = 0;
                                    dmgRealizado = parseInt(datosHabilidad.dmg) + ((parseInt(datosHabilidad.atkEnemigo) * 20) / 100);
                                    dmg += dmgRealizado;

                                    if(turnosBoostDef > 0){
                                        var defensaPersonaje = parseInt(datosHabilidad.def);
                                        defensaPersonaje += (defensaPersonaje*10) / 100;
                                        defensaPersonaje = Math.ceil(defensaPersonaje);
                                        if(dmg > defensaPersonaje){
                                            dmg -= defensaPersonaje;
                                        }else{
                                            dmg = 1;
                                        }
                                        
                                    }else{
                                        if(parseInt(datosHabilidad.dmg) > parseInt(datosHabilidad.def)){
                                            dmg = (parseInt(datosHabilidad.dmg) - parseInt(datosHabilidad.def));
                                        }else{
                                            dmg = 1;
                                        }
                                    }

                                    // En caso de no tenerlo
                                }else{
                                    if(turnosBoostDef > 0){
                                        var defensaPersonaje = parseInt(datosHabilidad.def);
                                        defensaPersonaje += (defensaPersonaje*10) / 100;
                                        defensaPersonaje = Math.ceil(defensaPersonaje);

                                        if(dmg > defensaPersonaje){
                                            dmg -= defensaPersonaje;
                                        }else{
                                            dmg = 1;
                                        }
                                        
                                        
                                    }else{
                                        if(parseInt(datosHabilidad.dmg) > parseInt(datosHabilidad.def)){
                                            dmg = (parseInt(datosHabilidad.dmg) - parseInt(datosHabilidad.def));
                                        }else{
                                            dmg = 1;
                                        }
                                    }
                                }

                                $("#textoCombate").html(datosHabilidad.nombreEnemigo + " usó " + datosHabilidad.nombreHabilidad + " causando " + dmg + " de daño.");
                            }

                            // En caso de que haya hecho un ataque normal
                        }else{
                             // En caso de que el personaje tenga algún boost de defensa
                            if(turnosBoostDef > 0){
                                var defensaPersonaje = parseInt(datosHabilidad.def);
                                defensaPersonaje += (defensaPersonaje*10) / 100;
                                defensaPersonaje = Math.ceil(defensaPersonaje);

                                if(dmg > defensaPersonaje){
                                    dmg -= defensaPersonaje;
                                }else{
                                    dmg = 1;
                                }
                                
                            }else{
                                if(parseInt(datosHabilidad.dmg) > parseInt(datosHabilidad.def)){
                                    dmg = (parseInt(datosHabilidad.dmg) - parseInt(datosHabilidad.def));
                                }else{
                                    dmg = 1;
                                }
                            }

                            

                            $("#textoCombate").html(datosHabilidad.nombreEnemigo + " atacó con todo lo que tiene y causó " + dmg);
                        }

                }else{
                    $("#textoCombate").html(datosHabilidad.nombreEnemigo + " ha fallado por estar cegado.");

                }

            // En caso de que sí esté congelado o dormido
            }else{
                if(turnosCongelar > 0){
                    $("#textoCombate").html(datosHabilidad.nombreEnemigo + " está congelado y no puede hacer nada.");
                }else if(turnosDormir > 0){
                    $("#textoCombate").html(datosHabilidad.nombreEnemigo + " está dormido y no puede hacer nada.");
                }else if (aturdido == true){
                    $("#textoCombate").html(datosHabilidad.nombreEnemigo + " está aturdido y no puede hacer nada.");
                    aturdido = false;

                    
                    if(vecesAturdido == 2){
                        vecesAturdido = 0;
                    }

                    $("#aturdirEnemigo").html("");
                }

            }

            // En caso de que el enemigo esté congelado
            if(turnosCongelar > 0){
                turnosCongelar--;
            }else{
                $("#congelarEnemigo").html("");
            }

            // En caso de que el enemigo esté dormido
            if(turnosDormir > 0){
                turnosDormir--;
            }else{
                $("#congelarEnemigo").html("");
            }

            if(turnosBoostDef <= 0){
                $("#defPersonaje").html("");
            }else{
                turnosBoostDef--;
            }

            if(turnosBoostMagia <= 0){
                $("#magiaPersonaje").html("");
            }else{
                turnosBoostMagia--;
            }

            // Se aplica el daño hecho
            if(defenderse == false){

                vidaPersonaje = vidaPersonaje - dmg;
            if(vidaPersonaje > 0){
                $("#vidaPersonaje").html(vidaPersonaje);
            }else{
                $("#textoCombate").html("¡Has perdido!");
                $("#vidaPersonaje").html(0);
                finBatalla();
            }

            }else{
                if(datosHabilidad.nombreHabilidad != 0){
                    $("#textoCombate").html("¡Conseguiste defenderte de " + datosHabilidad.nombreHabilidad + "!");
                }else{
                    $("#textoCombate").html("¡Conseguiste aguantar la paliza de " + datosHabilidad.nombreEnemigo + "!");
                }
                defenderse = false;
                $("#defensaPersonaje").html("");
            }
            
            
            turno = false;
            cambiarBotones();
        },
        error:function(){
            $("#textoCombate").html("DB ERROR");
        }
        });

    }

// FUNCIONES DE COMBATE POR PARTE DEL USUARIO

    // Función que aplica el veneno
    function aplicarVeneno() {
        var dmg = 0;
        if(turnosVenenoPersonaje > 0){
            dmg += 5;
            turnosVenenoPersonaje--;
        }else{
            $("#venenoEnemigo").html("");
        }

        return dmg;
    }

    // Función que aplica la quemadura
    function aplicarQuemadura() {
        var dmg = 0;
        if(turnosQuemadura > 0){
            dmg += 3;
            turnosQuemadura--;
        }else{
            $("#quemaduraEnemigo").html("");
        }

        return dmg;
    }

    // Función que comprueba si la habilidad es mágica o física y aplica los boosts correspondientes en caso de haberlos
    function comprobarTipoAtaque(tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad) {
        var dmg = 0;
        if(tipo == "fisico"){
                    
            if(turnosBoostAtk > 0){
                dmg += aplicarBoostAtaque(dmgHabilidad, ataquePersonaje);
                turnosBoostAtk--;
                dmg += ataquePersonaje;

            }else{
                dmg += ataquePersonaje;

            }

            }else if(tipo == "magico"){
                if(turnosBoostMagia > 0){
                    dmg += aplicarBoostMagia(dmgHabilidad, magiaPersonaje);
                    turnosBoostMagia--;
                    dmg += magiaPersonaje;
                }else{
                    dmg += magiaPersonaje;
                    $("#defPersonaje").html("");
                }
            }

            return Math.ceil(dmg);
    }

    // Aplica boost de ataque
    function aplicarBoostAtaque(dmg2, ataquePersonaje) {
        var dmg = 0;

        if(turnosBoostAtk > 0){
            dmg += ((dmg2 + ataquePersonaje) * 10) / 100;
            turnosBoostAtk--;
        }else{
            $("#atkPersonaje").html("");
        }

        return dmg;
    }

    function aplicarBoostLocura(ataquePersonaje) {
        var dmg2 = ataquePersonaje*10;
        var dmg = 0;
        if(turnosBoostAtk2 > 0){
            dmg += ((dmg2 + ataquePersonaje) * 30) / 100;
            turnosBoostAtk2--;
        }else{
            $("#atkPersonaje").html("");
        }

        return Math.ceil(dmg);
    }

    // Aplica boost de magia
    function aplicarBoostMagia(dmg2, magiaPersonaje) {
        var dmg = 0;

        if(turnosBoostMagia > 0){
            dmg += ((dmg2 + magiaPersonaje) * 10) / 100;
            turnosBoostMagia--;
        }else{
            $("#magiaPersonaje").html("");
        }

        return dmg;
    }

    // Función de uso de habilidades del personaje
    function usarHabilidad(idHabilidad, idPersonaje) {
        var params = {
            idPersonaje: idPersonaje,
            idHabilidad: idHabilidad
        };

        jQuery.ajax({
        url: "../Controller/c.habilidadesPersonaje.php",
        data:params,
        type: "POST",
        timeout: 5000,
        success:function(data){
            var habilidad = JSON.parse(data);
            console.log(data);
            var dmg = 0;
            var dmgHabilidad = parseInt(habilidad.dmg);
            var ataquePersonaje = parseInt(habilidad.ataque);
            var magiaPersonaje = parseInt(habilidad.magiaPersonaje);

            if(turno == false){
                
                    switch (habilidad.efecto) {
                        case "veneno":
                            if(turnosVenenoPersonaje <= 0){
                                turnosVenenoPersonaje = 3;
                                
                                $("#venenoEnemigo").html("<img src='../View/img/estados/veneno.png' />");
                            }

                            if(dmgHabilidad == 0){
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y envenenó al enemigo.");
                            }else{

                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                dmg += dmgHabilidad;
                                console.log(habilidad.nombre);

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y envenenó al enemigo causándole " + dmgHabilidad + " de daño.");
                            }
                            
                            break;
                            
                        case "quemar":
                            if(turnosQuemadura == 0){
                                turnosQuemadura = 3;
                                $("#quemaduraEnemigo").html("<img src='../View/img/estados/quemadura.png' />");
                            }
                            
                            

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y quemó al enemigo causándole " + dmgHabilidad + " de daño.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y quemó al enemigo.");
                            }

                            dmg += dmgHabilidad;
                            break;

                        case "congelar":
                            if(turnosCongelar == 0){
                                turnosCongelar = 3;
                                $("#congelarEnemigo").html("<img src='../View/img/estados/hielo.png' />");
                            }

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y congeló al enemigo causándole " + dmgHabilidad + " de daño.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y congeló al enemigo.");
                            }

                            dmg += dmgHabilidad;
                            break;
                        
                        case "cura":
                            var vidaTotalPersonaje = parseInt(habilidad.vidaPersonaje);
                            var magiaPersonaje = parseInt(habilidad.magiaPersonaje);
                            var porcentaje = 0;

                            if(dmgHabilidad == 0){
                                porcentaje = 20;
                            }else{
                                porcentaje = 50;
                            }

                            vidaRecuperada = (porcentaje * vidaTotalPersonaje) / 100;
                            vidaRecuperada += magiaPersonaje;
                            
                            var vidaTotal = vidaRecuperada + vidaPersonaje;

                            if(vidaTotal > vidaTotalPersonaje){
                                vidaPersonaje = vidaTotalPersonaje;
                            }else{
                                vidaPersonaje = vidaTotal;

                            }

                            $("#vidaPersonaje").html(vidaPersonaje);
                            $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y recuperó " + vidaRecuperada + " de vida.");
                            break;

                        case "ataque":
                            if(turnosBoostAtk == 0){
                                turnosBoostAtk = 3;
                                $("#atkPersonaje").append("<img src='../View/img/estados/boost_atk.png' />");
                            }

                            

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y aumentó su ataque.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y aumentó su ataque.");
                            }

                            dmg += dmgHabilidad;
                            break;

                        case "defensa":
                            if(turnosBoostDef == 0){
                                turnosBoostDef = 3;
                                $("#defPersonaje").append("<img src='../View/img/estados/boost_def.png' />");
                            }

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y aumentó su defensa.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y aumentó su defensa.");
                            }

                            dmg += dmgHabilidad;
                            break;

                        case "ceguera":
                            
                            if(turnosCeguera == 0){
                                turnosCeguera = 3;
                                $("#cegueraEnemigo").append("<img src='../View/img/estados/ceguera.png' />");
                            }

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y cegó al enemigo.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y cegó al enemigo.");
                            }

                            dmg += dmgHabilidad;

                            break;

                        case "magia":
                            if(turnosBoostMagia == 0){
                                turnosBoostMagia = 3;
                                $("#magiaPersonaje").append("<img src='../View/img/estados/boost_magia.png' />");
                            }

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y aumentó su poder mágico.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y aumentó su poder mágico.");
                            }

                            dmg += dmgHabilidad;
                            break;

                        case "dormir":
                            if(turnosDormir == 0){
                                turnosDormir = 3;
                                $("#dormirEnemigo").html("<img src='../View/img/estados/dormir.png' />");
                            }

                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y durmió al enemigo.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y durmió al enemigo.");
                            }

                            dmg += dmgHabilidad;
                            break;

                        case "ataque2":
                            if(turnosBoostAtk2 == 0){
                                turnosBoostAtk2 = 3;
                                $("#atkPersonaje").append("<img src='../View/img/estados/boost_atk2.png' />");
                                activarLocura();
                            }
                            
                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y aumentó mucho su ataque.");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y aumentó mucho su ataque.");
                            }

                            dmg += dmgHabilidad;
                            break;

                        case "doble":
                            if(dmgHabilidad > 0){
                                dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                dmg += dmgHabilidad;
                                dmg = dmg * 2;

                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño dos veces. (" + dmg + ")");
                            }else{
                                $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y aturdió al enemigo.");
                            }
                            break;


                            case "aturdir":
                            
                                if(aturdido == false){
                                    aturdido = true;
                                    vecesAturdido++;
                                    $("#aturdirEnemigo").append("<img src='../View/img/estados/aturdir.png' />");
                                }else if(vecesAturdido == 1){
                                    vecesAturdido++;
                                }

                                if(dmgHabilidad > 0){
                                    dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                                    

                                    if(vecesAturdido != 1){
                                        $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y no pudo aturdir al enemigo.");
                                    }else{
                                        $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " causó " + dmgHabilidad + " de daño y aturdió al enemigo.");
                                    }
                                }else{
                                    $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y aturdió al enemigo.");
                                }

                                dmg += dmgHabilidad;
                            break;

                        default:
                            dmgHabilidad += comprobarTipoAtaque(habilidad.tipo, ataquePersonaje, magiaPersonaje, dmgHabilidad);
                            dmg += dmgHabilidad;
                            $("#textoCombate").html(habilidad.nombrePersonaje + " usó " + habilidad.nombre + " y causó " + dmgHabilidad + " de daño .");
                            break;
                    }

                
                dmg += aplicarVeneno();
                dmg += aplicarQuemadura();

                // Aplicar daño al enemigo
                
                vidaRestante = vidaRestante - dmg;

                if(vidaRestante <= 0){
                    $("#vidaEnemigo").html(0);
                    $("#textoCombate").html("¡Bien hecho, has conseguido salir victorioso!");
                    finBatalla();
                }else{
                    $("#vidaEnemigo").html(vidaRestante);
                }
                
                // Aplicar gasto de pm y ph
                pmMaximo = pmMaximo - habilidad.costePm;
                phMaximo = phMaximo - habilidad.costePh;
                $("#pmRestantes").html(pmMaximo);
                $("#phRestantes").html(phMaximo);
                turno = true;
                cambiarBotones();
            }else{
                turnoEnemigo(id_Mision);
                turno = false;
                cambiarBotones();
            }
                

            
        },
        error:function(){
            $("#textoCombate").html("Lo sentimos, aún no está disponible.");
        }
        });

        if($(".ventanaModalHabilidades").css("visibility") == "hidden"){
            $(".ventanaModalHabilidades").css("visibility", "visible");
            $(".ventanaModal").css("visibility", "hidden");
        }else{
            $(".ventanaModalHabilidades").css("visibility", "hidden");
        }

    }

    // Función de ataque normal del personaje
    function ataqueNormal(nombrePersonaje, atk) {

        if(turno == false){
            var dmg = atk + 10;
            dmg += aplicarVeneno();
            dmg += aplicarQuemadura();
            
            if(turnosBoostAtk2 > 0){
                dmg += aplicarBoostLocura(dmg);
            }else{
                desactivarLocura();
                dmg += aplicarBoostAtaque();
            }
            vidaRestante = vidaRestante - dmg;
            if(vidaRestante <= 0){
                $("#vidaEnemigo").html(0);
                $("#textoCombate").html("¡Bien hecho, has conseguido salir victorioso!");
                finBatalla();
            }else{
                $("#vidaEnemigo").html(vidaRestante);
                $("#textoCombate").html(nombrePersonaje + " atacó e infringió " + dmg + " de daño.");
            }
            

            turno = true;
            cambiarBotones();
        }else{
            turnoEnemigo(id_Mision);
            turno = false;
        }
    }

    function defender(nombrePersonaje) {
        if(turno == false){
            $("#textoCombate").html(nombrePersonaje + " se está defendiendo.");
            $("#defensaPersonaje").html("<img src='../View/img/estados/def.png' />");
            defenderse = true;
            turno = true;
            cambiarBotones();
        }else{
            turnoEnemigo(id_Mision);
            turno = false;
            cambiarBotones();
        }
    }

    // Función que modifica los botones según el turno
    function cambiarBotones() {  
        if(turno == false){
            $("#btnHabilidades").css("display", "block");
            $("#btnHabilidades").html("Habilidades");
            $("#btnAtaqueNormal").html("Ataque normal");
            $("#btnDef").css("display", "block");
            $("#btnDef").html("Defenderse");
        }else{
            $("#btnHabilidades").css("display", "none");
            $("#btnAtaqueNormal").html("Pasar turno enemigo");
            $("#btnDef").css("display", "none");
        }
    }

    
    function activarLocura(){
        $("#btnHabilidades").attr("disabled", true);
    }

    function desactivarLocura(){
        $("#btnHabilidades").removeAttr('disabled');
    }
</script>
<body onload="comprobarTurno(<?= $data['mision']->getIdMision() ?>, <?= $data['personajeSeleccionado']->getIdPersonaje() ?>)">

    <!-- Contenedor que contendrá la información del enemigo -->
    <div class="containerEnemigo">
        <div class="enemigo">
            <img src="<?= $carpetaEnemigos.$data['enemigo']->getFoto() ?>" alt="">
        </div>
        <p class="vida">
            <img src="../View/img/stats/vida.png" alt=""> 
            <span id="vidaEnemigo"><?= $data['enemigo']->getVida() ?></span> / <?= $data['enemigo']->getVida() ?>
            <span id="venenoEnemigo"></span>
            <span id="congelarEnemigo"></span>
            <span id="cegueraEnemigo"></span>
            <span id="quemaduraEnemigo"></span>
            <span id="dormirEnemigo"></span>
            <span id="aturdirEnemigo"></span>
        </p>
    </div>

    
    <!-- Contenedor que contendrá el menú de combate del jugador -->
    <div class="menuJugador">
        <div class="personaje">
            
            <p class="vida">
                <img src="../View/img/stats/vida.png" alt="" height="10" width="10"> 
                <span id="vidaPersonaje"><?= $data['estadisticas']->getVida() ?></span> / <?= $data['estadisticas']->getVida() ?>
                <span id="venenoPersonaje"></span>
                <span id="defPersonaje"></span>
                <span id="magiaPersonaje"></span>
                <span id="atkPersonaje"></span>
                <span id="defensaPersonaje"></span>
            </p>
            <img src="<?= $carpetaPersonajes.$data['personajeSeleccionado']->getFoto() ?>" alt="">
        </div>

        <div class="datosPersonaje">
            <div class="stats">
                <button class="btnStats" onclick="abrirVentanaEstadisticas(<?= $data['personajeSeleccionado']->getIdPersonaje() ?>)">Ver estadísticas</button>
                <p class="pm btnStats">
                    <span id="pmRestantes"> 
                        <?= $data['estadisticas']->getPm() ?> 
                    </span> 
                / 
                    <span>
                        <?= $data['estadisticas']->getPm() ?>
                    </span>
                </p>
                <p class="ph btnStats">
                    <span id="phRestantes">
                        <?= $data['estadisticas']->getPh() ?> 
                    </span> 
                        / 
                    <span>
                        <?= $data['estadisticas']->getPh() ?>
                    </span>
                </p>
            </div>

            <div class="textoCombate">
                <span id="textoCombate"></span>
            </div>
        </div>

        <div class="menuCombate">

            <div class="habilidades">
                <button id="btnHabilidades" class="botones" onclick="abrirVentanaHabilidades(<?= $data['personajeSeleccionado']->getIdPersonaje() ?>, <?= $data['personajeSeleccionado']->getIdClase() ?>)">
                    Habilidades
                </button>
            </div>
            
            <div class="ataqueNormal">
                <button id="btnAtaqueNormal" class="botones" onclick="ataqueNormal('<?= $data['personajeSeleccionado']->getNombre() ?>',<?= $data['estadisticas']->getAtk() ?>)">
                    Ataque normal
                </button>
            </div>

            <div class="defender">
                <button id="btnDef" class="botones" onclick="defender('<?= $data['personajeSeleccionado']->getNombre() ?>')">
                    Defenderse
                </button>
            </div>

            <div class="abandonar">
                <button id="btnAbandonar" class="botones" onclick="$(location).attr('href','../Controller/c.guardarUsuario.php');">
                    <span>Abandonar</span>
                </button>

                <button id="btnContinuar" class="botones" onclick="$(location).attr('href','../Controller/c.listarPersonajes.php');" style="display: none;">
                    <span>Continuar</span>
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