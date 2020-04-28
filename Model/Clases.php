<?php 
require_once "../Model/IvaliceBD.php";
class Clase{

    private $id;
    private $nombre_clase;
    private $descripcion;

    /**
     * Class constructor.
     */
    public function __construct($id, $nombre_clase, $descripcion){
        $this->id = $id;
        $this->nombre_clase = $nombre_clase;
        $this->descripcion = $descripcion;
    }

    
    // Devuelve todas las clases de los personajes
    public static function getClases(){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT idClase, nombre_clase, descripcion from clases";
        $consulta = $conexion->query($registros);
        $clases = [];

        while ($clase = $consulta->fetchObject()) {
            $clases[] = new Clase($clase->idClase, $clase->nombre_clase, $clase->descripcion);
        }

        return $clases;
    }

    public static function getClaseById($idClase){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT idClase, nombre_clase, descripcion from clases WHERE idClase = '".$idClase."'";
        $registro = $conexion->query($seleccion);
        $consulta = $registro->fetchObject();
        $clase = new Clase($consulta->idClase, $consulta->nombre_clase, $consulta->descripcion);
        return $clase;
    }
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre_clase
     */ 
    public function getNombre_clase()
    {
        return $this->nombre_clase;
    }

    /**
     * Set the value of nombre_clase
     *
     * @return  self
     */ 
    public function setNombre_clase($nombre_clase)
    {
        $this->nombre_clase = $nombre_clase;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}

?>