<?php 

require_once "../Model/IvaliceBD.php";

class Misiones{

    private $idMision;
    private $nombreMision;
    private $foto;
    private $preHistoria;
    private $postHistoria;
    private $dificultad;

    /**
     * Class constructor.
     */
    public function __construct($idMision, $nombreMision, $foto, $preHistoria, $postHistoria, $dificultad)
    {
        $this->idMision = $idMision;
        $this->nombreMision = $nombreMision;
        $this->foto = $foto;
        $this->preHistoria = $preHistoria;
        $this->postHistoria = $postHistoria;
        $this->dificultad = $dificultad;
    }

    public static function getMisiones(){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * FROM misiones";
        $consulta = $conexion->query($registros);
        $misiones = [];

        while ($mision = $consulta->fetchObject()) {
            $misiones[] = new Misiones($mision->idMision, $mision->nombreMision, $mision->foto, $mision->preHistoria, $mision->postHistoria, $mision->dificultad);
        }

        return $misiones;
    }

    public static function getMisionById($idMision){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * FROM misiones WHERE idMision=\"".$idMision."\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $mision = new Misiones($registro->idMision, $registro->nombreMision, $registro->foto, $registro->preHistoria, $registro->postHistoria, $registro->dificultad);
        
        return $mision;
    }

    public function getIdMision()
    {
        return $this->idMision;
    }


    public function setIdMision($idMision)
    {
        $this->idMision = $idMision;

        return $this;
    }

    public function getNombreMision()
    {
        return $this->nombreMision;
    }

    public function setNombreMision($nombreMision)
    {
        $this->nombreMision = $nombreMision;

        return $this;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDificultad()
    {
        return $this->dificultad;
    }

    public function setDificultad($dificultad)
    {
        $this->dificultad = $dificultad;

        return $this;
    }
}

?>