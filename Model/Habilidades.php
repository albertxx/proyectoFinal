<?php 

require_once "../Model/IvaliceBD.php";

class Habilidades{

    private $idClase;
    private $idHabilidad;
    private $nombre;
    private $dmg;
    private $efecto;
    private $costePm;
    private $costePh;
    private $descripcion;
    private $tipo;
    private $nivel_requerido;

    /**
     * Class constructor.
     */
    public function __construct($idClase, $idHabilidad, $nombre, $descripcion, $dmg, $efecto, $costePm, $costePh, $tipo, $nivel_requerido)
    {
        $this->idClase = $idClase;
        $this->idHabilidad = $idHabilidad;
        $this->nombre = $nombre;
        $this->dmg = $dmg;
        $this->efecto = $efecto;
        $this->costePm = $costePm;
        $this->costePh = $costePh;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
        $this->nivel_requerido = $nivel_requerido;
    }

    public static function getHabilidadesByClase($idClase){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * FROM habilidades WHERE idClase=\"".$idClase."\"";
        $consulta = $conexion->query($registros);
        $habilidades = [];

        while ($habilidad = $consulta->fetchObject()) {
            $habilidades[] = new Habilidades($habilidad->idClase, $habilidad->idHabilidad, $habilidad->nombre, $habilidad->descripcion, $habilidad->dmg, $habilidad->efecto, $habilidad->costePm, $habilidad->costePh, $habilidad->tipo, $habilidad->nivel_requerido);
        }

        return $habilidades;
    }

    public static function getHabilidadById($idHabilidad){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * FROM habilidades WHERE idHabilidad=\"".$idHabilidad."\"";
        $consulta = $conexion->query($registros);
        $habilidadBD = $consulta->fetchObject();
        $habilidad = new Habilidades($habilidadBD->idClase, $habilidadBD->idHabilidad, $habilidadBD->nombre, $habilidadBD->descripcion, $habilidadBD->dmg, $habilidadBD->efecto, $habilidadBD->costePm, $habilidadBD->costePh, $habilidadBD->tipo, $habilidadBD->nivel_requerido);

        return $habilidad;
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

    /**
     * Get the value of dmg
     */ 
    public function getDmg()
    {
        return $this->dmg;
    }

    /**
     * Set the value of dmg
     *
     * @return  self
     */ 
    public function setDmg($dmg)
    {
        $this->dmg = $dmg;

        return $this;
    }

    /**
     * Get the value of efecto
     */ 
    public function getEfecto()
    {
        return $this->efecto;
    }

    /**
     * Set the value of efecto
     *
     * @return  self
     */ 
    public function setEfecto($efecto)
    {
        $this->efecto = $efecto;

        return $this;
    }

    /**
     * Get the value of costePm
     */ 
    public function getCostePm()
    {
        return $this->costePm;
    }

    /**
     * Set the value of costePm
     *
     * @return  self
     */ 
    public function setCostePm($costePm)
    {
        $this->costePm = $costePm;

        return $this;
    }

    /**
     * Get the value of costePh
     */ 
    public function getCostePh()
    {
        return $this->costePh;
    }

    /**
     * Set the value of costePh
     *
     * @return  self
     */ 
    public function setCostePh($costePh)
    {
        $this->costePh = $costePh;

        return $this;
    }

    /**
     * Get the value of tipo
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     *
     * @return  self
     */ 
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
}

?>