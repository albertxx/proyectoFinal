<?php 

require_once "../Model/Clases.php";
if($_POST['idClase'] != ""){
    $idClase = $_POST['idClase'];
    $clase = Clase::getClaseById($idClase);
    $descripcionClase = $clase->getDescripcion();
    
    switch ($idClase) {
        case '1':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 175,
                "atk" => 3,
                "def" => 3,
                "magia" => 1,
                "velocidad" => 3,
                "pm" => 115,
                "ph" => 115
            ];
            break;
        case '2':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 120,
                "atk" => 2,
                "def" => 2,
                "magia" => 5,
                "velocidad" => 2,
                "pm" => 130,
                "ph" => 50
            ];
            break;

        case '3':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 250,
                "atk" => 2,
                "def" => 5,
                "magia" => 3,
                "velocidad" => 2,
                "pm" => 125,
                "ph" => 125
            ];
            break;
        case '4':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 170,
                "atk" => 4,
                "def" => 2,
                "magia" => 2,
                "velocidad" => 5,
                "pm" => 80,
                "ph" => 175
            ];
            break;

        case '5':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 200,
                "atk" => 5,
                "def" => 1,
                "magia" => 1,
                "velocidad" => 3,
                "pm" => 50,
                "ph" => 150
            ];
            break;
        default:
            break;
    }
    echo json_encode($clase);
}

?>