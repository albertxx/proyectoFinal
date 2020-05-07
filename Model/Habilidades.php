<?php 

require_once "../Model/IvaliceBD.php";

class Habilidades{

    private $idClase;
    private $idHabilidad;
    private $nombre;
    private $descripcion;
    private $nivel_requerido;

    /**
     * Class constructor.
     */
    public function __construct($idClase, $idHabilidad, $nombre, $descripcion, $nivel_requerido)
    {
        $this->idClase = $idClase;
        $this->idHabilidad = $idHabilidad;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->nivel_requerido = $nivel_requerido;
    }

    public static function getHabilidadesByClase($idClase){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * FROM habilidades WHERE idClase=\"".$idClase."\"";
        $consulta = $conexion->query($registros);
        $habilidades = [];

        while ($habilidad = $consulta->fetchObject()) {
            $habilidades[] = new Habilidades($habilidad->idClase, $habilidad->idHabilidad, $habilidad->nombre, $habilidad->descripcion, $habilidad->nivel_requerido);
        }

        return $habilidades;
    }
    /**
     * Get the value of idClase
     */ 
    public function getIdClase()
    {
        return $this->idClase;
    }

    /**
     * Set the value of idClase
     *
     * @return  self
     */ 
    public function setIdClase($idClase)
    {
        $this->idClase = $idClase;

        return $this;
    }

    /**
     * Get the value of idHabilidad
     */ 
    public function getIdHabilidad()
    {
        return $this->idHabilidad;
    }

    /**
     * Set the value of idHabilidad
     *
     * @return  self
     */ 
    public function setIdHabilidad($idHabilidad)
    {
        $this->idHabilidad = $idHabilidad;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

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

    /**
     * Get the value of nivel_requerido
     */ 
    public function getNivel_requerido()
    {
        return $this->nivel_requerido;
    }

    /**
     * Set the value of nivel_requerido
     *
     * @return  self
     */ 
    public function setNivel_requerido($nivel_requerido)
    {
        $this->nivel_requerido = $nivel_requerido;

        return $this;
    }
}

?>