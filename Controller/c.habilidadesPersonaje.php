<?php 
require_once "../Model/Habilidades.php";
require_once "../Model/Personaje.php";


$habilidades = Habilidades::getHabilidadesByClase($_POST['idClase']);
$personaje = Personaje::getPersonajeById($_POST['idPersonaje']);

$arrayHabilidades = [];
    for ($i=0; $i < count($habilidades); $i++) { 
        $arrayHabilidades[] = [
            "idClase" => $habilidades[$i]->getIdClase(),
            "idHabilidad" => $habilidades[$i]->getIdHabilidad(),
            "nombre" => $habilidades[$i]->getNombre(),
            "descripcion" => $habilidades[$i]->getDescripcion(),
            "nivel_requerido" => $habilidades[$i]->getNivel_requerido()
        ];
    }

    $arrayHabilidades[] = [
        "nivelPersonaje" => $personaje->getNivel(),
        "nombre_personaje" => $personaje->getNombre()
    ];

echo json_encode($arrayHabilidades);
?>