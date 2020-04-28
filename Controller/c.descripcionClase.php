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
                "magia" => 1
            ];
            break;
        case '2':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 120,
                "atk" => 2,
                "def" => 2,
                "magia" => 5
            ];
            break;

        case '3':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 250,
                "atk" => 2,
                "def" => 5,
                "magia" => 3
            ];
            break;
        case '4':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 140,
                "atk" => 4,
                "def" => 2,
                "magia" => 2
            ];
            break;

        case '5':
            $clase = [
                "descripcion" => $descripcionClase,
                "vida" => 200,
                "atk" => 5,
                "def" => 1,
                "magia" => 1
            ];
            break;
        default:
            break;
    }
    echo json_encode($clase);
}

?>