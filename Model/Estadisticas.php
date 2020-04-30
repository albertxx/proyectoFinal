<?php 
require_once "../Model/IvaliceBD.php";

class Estadisticas{

    private $idPersonaje;
    private $vida;
    private $atk;
    private $def;
    private $magia;
    private $pm;
    private $ph;

    /**
     * Class constructor.
     */
    public function __construct($idPersonaje, $vida, $atk, $def, $magia, $pm, $ph)
    {   
        $this->idPersonaje = $idPersonaje;
        $this->vida = $vida;
        $this->atk = $atk;
        $this->def = $def;
        $this->magia = $magia;
        $this->pm = $pm;
        $this->ph = $ph;
    }

    
    public function insertarEstadisticasIniciales(){
        $conexion = IvaliceBD::connectBD();
        $insertarStats = "INSERT INTO estadisticas (vida, atk, def, magia, pm, ph) VALUES ('$this->vida', '$this->atk', '$this->def', '$this->magia', '$this->pm', '$this->ph')";
        $conexion->exec($insertarStats);
    }

    public static function getEstadisticasByPersonaje($idPersonaje){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * from estadisticas WHERE idPersonaje = '".$idPersonaje."'";
        $registro = $conexion->query($seleccion);
        $consulta = $registro->fetchObject();
        $estadisticasPersonaje = new Estadisticas($consulta->idPersonaje, $consulta->vida, $consulta->atk, $consulta->def, $consulta->magia, $consulta->pm, $consulta->ph);
        return $estadisticasPersonaje;
    }
    /**
     * Get the value of vida
     */ 
    public function getVida()
    {
        return $this->vida;
    }

    /**
     * Set the value of vida
     *
     * @return  self
     */ 
    public function setVida($vida)
    {
        $this->vida = $vida;

        return $this;
    }

    /**
     * Get the value of atk
     */ 
    public function getAtk()
    {
        return $this->atk;
    }

    /**
     * Set the value of atk
     *
     * @return  self
     */ 
    public function setAtk($atk)
    {
        $this->atk = $atk;

        return $this;
    }

    /**
     * Get the value of def
     */ 
    public function getDef()
    {
        return $this->def;
    }

    /**
     * Set the value of def
     *
     * @return  self
     */ 
    public function setDef($def)
    {
        $this->def = $def;

        return $this;
    }

    /**
     * Get the value of magia
     */ 
    public function getMagia()
    {
        return $this->magia;
    }

    /**
     * Set the value of magia
     *
     * @return  self
     */ 
    public function setMagia($magia)
    {
        $this->magia = $magia;

        return $this;
    }

    /**
     * Get the value of idPersonaje
     */ 
    public function getIdPersonaje()
    {
        return $this->idPersonaje;
    }

    /**
     * Set the value of idPersonaje
     *
     * @return  self
     */ 
    public function setIdPersonaje($idPersonaje)
    {
        $this->idPersonaje = $idPersonaje;

        return $this;
    }

    /**
     * Get the value of pm
     */ 
    public function getPm()
    {
        return $this->pm;
    }

    /**
     * Set the value of pm
     *
     * @return  self
     */ 
    public function setPm($pm)
    {
        $this->pm = $pm;

        return $this;
    }

    /**
     * Get the value of ph
     */ 
    public function getPh()
    {
        return $this->ph;
    }

    /**
     * Set the value of ph
     *
     * @return  self
     */ 
    public function setPh($ph)
    {
        $this->ph = $ph;

        return $this;
    }
}

?>