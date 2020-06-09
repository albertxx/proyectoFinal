<?php 
require_once "../Model/Habilidades.php";
require_once "../Model/Personaje.php";
require_once "../Model/Estadisticas.php";

if(!isset($_POST['idHabilidad'])){
    $habilidades = Habilidades::getHabilidadesByClase($_REQUEST['idClase']);
    $personaje = Personaje::getPersonajeById($_REQUEST['idPersonaje']);

    $arrayHabilidades = [];
        for ($i=0; $i < count($habilidades); $i++) { 
            $arrayHabilidades[] = [
                "idClase" => $habilidades[$i]->getIdClase(),
                "idHabilidad" => $habilidades[$i]->getIdHabilidad(),
                "nombre" => $habilidades[$i]->getNombre(),
                "costePm" => $habilidades[$i]->getCostePm(),
                "costePh" => $habilidades[$i]->getCostePh(),
                "descripcion" => $habilidades[$i]->getDescripcion(),
                "nivel_requerido" => $habilidades[$i]->getNivel_requerido()
            ];
        }

        $arrayHabilidades[] = [
            "nivelPersonaje" => $personaje->getNivel(),
            "nombre_personaje" => $personaje->getNombre(),
            "idPersonaje" => $personaje->getIdPersonaje()
        ];

    echo json_encode($arrayHabilidades);
}else{
    $habilidad = Habilidades::getHabilidadById($_POST['idHabilidad']);
    $personaje = Personaje::getPersonajeById($_POST['idPersonaje']);
    $estadisticas = Estadisticas::getEstadisticasByPersonaje($_POST['idPersonaje']);

    $jsonHabilidad = [
        "idClase" => $habilidad->getIdClase(),
        "idHabilidad" => $habilidad->getIdHabilidad(),
        "nombre" => $habilidad->getNombre(),
        "dmg" => $habilidad->getDmg(),
        "costePm" => $habilidad->getCostePm(),
        "costePh" => $habilidad->getCostePh(),
        "descripcion" => $habilidad->getDescripcion(),
        "nivel_requerido" => $habilidad->getNivel_requerido(),
        "efecto" => $habilidad->getEfecto(),
        "nombrePersonaje" => $personaje->getNombre(),
        "ataque" => $estadisticas->getAtk(),
        "vidaPersonaje" => $estadisticas->getVida(),
        "magiaPersonaje" => $estadisticas->getMagia(),
        "tipo" => $habilidad->getTipo()

    ];

    echo json_encode($jsonHabilidad);
}
?>