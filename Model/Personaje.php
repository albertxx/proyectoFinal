<?php 

require_once "../Model/IvaliceBD.php";

class Personaje{

    private $idPersonaje;
    private $nombre;
    private $idClase;
    private $nivel;
    private $foto;
    private $nick_usuario;

    /**
     * Class constructor.
     */
    public function __construct($idPersonaje, $nombre, $idClase, $nivel, $foto, $nick_usuario)
    {
        $this->idPersonaje = $idPersonaje;
        $this->nombre = $nombre;
        $this->idClase = $idClase;
        $this->nivel = $nivel;
        $this->foto = $foto;
        $this->nick_usuario = $nick_usuario;
    }

    public function insertarPersonaje(){
        $conexion = IvaliceBD::connectBD();
        $insertarPersonaje = "INSERT INTO personajes (idPersonaje, nombre, idClase, nivel, foto, nick_usuario) VALUES (null, '$this->nombre', '$this->idClase', '$this->nivel', '$this->foto', '$this->nick_usuario)";
        $conexion->exec($insertarPersonaje);
    }

    public static function getPersonajeById($id){

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
     * Get the value of nivel
     */ 
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set the value of nivel
     *
     * @return  self
     */ 
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;

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

    /**
     * Get the value of nick_usuario
     */ 
    public function getNick_usuario()
    {
        return $this->nick_usuario;
    }

    /**
     * Set the value of nick_usuario
     *
     * @return  self
     */ 
    public function setNick_usuario($nick_usuario)
    {
        $this->nick_usuario = $nick_usuario;

        return $this;
    }
}

?>