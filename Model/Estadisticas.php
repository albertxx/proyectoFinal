<?php 
require_once "../Model/IvaliceBD.php";

class Estadisticas{

    private $idPersonaje;
    private $vida;
    private $atk;
    private $def;
    private $magia;
    private $velocidad;
    private $pm;
    private $ph;

    /**
     * Class constructor.
     */
    public function __construct($idPersonaje, $vida, $atk, $def, $magia, $velocidad, $pm, $ph)
    {   
        $this->idPersonaje = $idPersonaje;
        $this->vida = $vida;
        $this->atk = $atk;
        $this->def = $def;
        $this->magia = $magia;
        $this->velocidad = $velocidad;
        $this->pm = $pm;
        $this->ph = $ph;
    }

    
    public function insertarEstadisticasIniciales(){
        $conexion = IvaliceBD::connectBD();
        $insertarStats = "INSERT INTO estadisticas (vida, atk, def, magia, velocidad, pm, ph) VALUES ('$this->vida', '$this->atk', '$this->def', '$this->magia', '$this->velocidad', '$this->pm', '$this->ph')";
        $conexion->exec($insertarStats);
    }

    public static function getEstadisticasByPersonaje($idPersonaje){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * from estadisticas WHERE idPersonaje = '".$idPersonaje."'";
        $registro = $conexion->query($seleccion);
        $consulta = $registro->fetchObject();
        $estadisticasPersonaje = new Estadisticas($consulta->idPersonaje, $consulta->vida, $consulta->atk, $consulta->def, $consulta->magia, $consulta->velocidad, $consulta->pm, $consulta->ph);
        return $estadisticasPersonaje;
    }

    public static function subirNivel($idPersonaje)
    {
        $conexion = IvaliceBD::connectDB();
        $personaje = Personaje::getPersonajeById($idPersonaje);
        $estadisticas = Estadisticas::getEstadisticasByPersonaje($idPersonaje);

        switch ($personaje->getIdClase()) {
            case '1':
                $vida = 25;
                $atk = 2;
                $def = 2;
                $magia = 1;
                $velocidad = 1;
                $pm = 10;
                $ph = 20;

                break;
            case '2':
                $vida = 25;
                $atk = 1;
                $def = 1;
                $magia = 4;
                $velocidad = 1;
                $pm = 25;
                $ph = 10;
                break;
    
            case '3':
                $vida = 50;
                $atk = 1;
                $def = 3;
                $magia = 2;
                $velocidad = 1;
                $pm = 20;
                $ph = 20;
                break;
            case '4':
                $vida = 20;
                $atk = 3;
                $def = 1;
                $magia = 1;
                $velocidad = 3;
                $pm = 10;
                $ph = 20;
                break;
    
            case '5':
                $vida = 20;
                $atk = 4;
                $def = 1;
                $magia = 1;
                $velocidad = 4;
                $pm = 10;
                $ph = 20;
                break;
            default:
                break;
        }

        $nuevaVida = $vida + $estadisticas->getVida();
        $nuevoAtk = $atk + $estadisticas->getAtk();
        $nuevaDef = $def + $estadisticas->getDef();
        $nuevaMagia = $magia + $estadisticas->getMagia();
        $nuevaVelocidad = $velocidad + $estadisticas->getVelocidad();
        $nPm = $pm + $estadisticas->getPm();
        $nPh = $ph + $estadisticas->getPh();

        $aumentoStats = "UPDATE estadisticas SET idPersonaje='".$idPersonaje."', vida='".$nuevaVida."',atk='".$nuevoAtk."', def='".$nuevaDef."', magia='".$nuevaMagia."', velocidad='".$nuevaVelocidad."', pm='".$nPm."', ph='".$nPh."' WHERE idPersonaje='".$idPersonaje."';";

        $conexion->exec($aumentoStats);
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
}

?>