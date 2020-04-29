<?php 
require_once "../Model/IvaliceBD.php";

class Estadisticas{

    private $idPersonaje;
    private $vida;
    private $atk;
    private $def;
    private $magia;

    /**
     * Class constructor.
     */
    public function __construct($idPersonaje, $vida, $atk, $def, $magia)
    {   
        $this->idPersonaje = $idPersonaje;
        $this->vida = $vida;
        $this->atk = $atk;
        $this->def = $def;
        $this->magia = $magia;
    }

    
    public function insertarEstadisticasIniciales(){
        $conexion = IvaliceBD::connectBD();
        $insertarStats = "INSERT INTO estadisticas (vida, atk, def, magia) VALUES ('$this->vida', '$this->atk', '$this->def', '$this->magia')";
        $conexion->exec($insertarStats);
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
}

?>