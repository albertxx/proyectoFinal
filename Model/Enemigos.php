<?php

require_once "../Model/IvaliceBD.php";

class Enemigos{

    private $nombre;
    private $vida;
    private $atk;
    private $velocidad;
    private $idMision;
    private $foto;

    /**
     * Class constructor.
     */
    public function __construct($nombre, $vida, $atk, $velocidad, $idMision, $foto)
    {
        
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->atk = $atk;
        $this->velocidad = $velocidad;
        $this->idMision = $idMision;
        $this->foto = $foto;
    }

    public static function getEnemigoByIdMision($idMision){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * FROM enemigos WHERE idMision=\"".$idMision."\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $enemigo = new Enemigos($registro->nombre, $registro->vida, $registro->atk, $registro->velocidad, $registro->idMision, $registro->foto);
        
        return $enemigo;
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
     * Get the value of velocidad
     */ 
    public function getVelocidad()
    {
        return $this->velocidad;
    }

    /**
     * Set the value of velocidad
     *
     * @return  self
     */ 
    public function setVelocidad($velocidad)
    {
        $this->velocidad = $velocidad;

        return $this;
    }

    /**
     * Get the value of idMision
     */ 
    public function getIdMision()
    {
        return $this->idMision;
    }

    /**
     * Set the value of idMision
     *
     * @return  self
     */ 
    public function setIdMision($idMision)
    {
        $this->idMision = $idMision;

        return $this;
    }

    /**
     * Get the value of foto
     */ 
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set the value of foto
     *
     * @return  self
     */ 
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }
}

?>