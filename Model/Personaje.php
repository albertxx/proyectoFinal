<?php 

require_once "../Model/IvaliceBD.php";
require_once "../Model/Estadisticas.php";

class Personaje{

    private $idPersonaje;
    private $nombre;
    private $idClase;
    private $nivel;
    private $foto;
    private $xp;
    private $nick_usuario;

    /**
     * Class constructor.
     */
    public function __construct($idPersonaje, $nombre, $idClase, $nivel, $foto, $xp, $nick_usuario)
    {
        $this->idPersonaje = $idPersonaje;
        $this->nombre = $nombre;
        $this->idClase = $idClase;
        $this->nivel = $nivel;
        $this->foto = $foto;
        $this->xp = $xp;
        $this->nick_usuario = $nick_usuario;
    }

    // Esta función inserta el personaje en la bd y tras ello, sus estadísticas iniciales
    public function insertarPersonaje($vida, $atk, $def, $magia, $velocidad, $pm, $ph){
        $conexion = IvaliceBD::connectDB();
        // Inserción de personaje en la BD
        $insertarPersonaje = "INSERT INTO personajes (idPersonaje, Nombre, idClase, Nivel, foto, xp, nick_usuario) VALUES ('$this->idPersonaje', '$this->nombre', '$this->idClase', $this->nivel, '$this->foto', '$this->xp', '$this->nick_usuario')";
        $conexion->exec($insertarPersonaje);

        // Recupera el personaje creado anteriormente
        $personaje = Personaje::getUltimoPersonajeCreadoById($this->nick_usuario);
        // Inserción de estadísticas base
        $insertarStats = "INSERT INTO estadisticas (idPersonaje, vida, atk, def, magia, velocidad, pm, ph) values ('$personaje->idPersonaje', '$vida', '$atk', '$def', '$magia', '$velocidad', '$pm', '$ph')";
        $conexion->exec($insertarStats);
    }

    // Devuelve un array con todos los personajes creados por el usuario
    public static function getPersonajesByNick($nick){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * FROM personajes WHERE nick_usuario=\"".$nick."\"";
        $consulta = $conexion->query($registros);
        $personajes = [];

        while ($personaje = $consulta->fetchObject()) {
            $personajes[] = new Personaje($personaje->idPersonaje, $personaje->Nombre, $personaje->idClase, $personaje->Nivel, $personaje->foto, $personaje->xp, $personaje->nick_usuario);
        }

        return $personajes;
    }

    // Rescata el último personaje creado por el usuario
    public static function getUltimoPersonajeCreadoById($id){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * FROM personajes WHERE nick_usuario=\"".$id."\"";
        $consulta = $conexion->query($seleccion);
        
        while($registro = $consulta->fetchObject()){
            $ultimoPersonaje = $registro;
        }

        $personaje = new Personaje($ultimoPersonaje->idPersonaje, $ultimoPersonaje->Nombre, $ultimoPersonaje->idClase, $ultimoPersonaje->Nivel, $ultimoPersonaje->foto, $ultimoPersonaje->xp, $ultimoPersonaje->nick_usuario);
        return $personaje;
    }

    public static function getPersonajeById($idPersonaje){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * FROM personajes WHERE idPersonaje=\"".$idPersonaje."\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $personaje = new Personaje($registro->idPersonaje, $registro->Nombre, $registro->idClase, $registro->Nivel, $registro->foto, $registro->xp, $registro->nick_usuario);
        
        return $personaje;
    }

    public static function modificarNick_usuario($nickAntiguo, $nuevoNick){
        $conexion = IvaliceBD::connectDB();
        $personajes = Personaje::getPersonajesByNick($nickAntiguo);
        
        for ($i=0; $i < count($personajes); $i++) {
            
            $id = $personajes[$i]->getIdPersonaje();
            $nombre = $personajes[$i]->getNombre();
            $clase = $personajes[$i]->getIdClase();
            $nivel = $personajes[$i]->getNivel();
            $foto = $personajes[$i]->getFoto();
            $xp = $personajes[$i]->getXp();

            $modificarNick = "UPDATE personajes SET idPersonaje='".$id."', Nombre='".$nombre."', idClase='".$clase."', Nivel='".$nivel."', foto='".$foto."', xp='".$xp."', nick_usuario='".$nuevoNick."' WHERE nick_usuario='".$nickAntiguo."';";
            $conexion->exec($modificarNick);
        }
    }

    public function borrarPersonaje(){
        $conexion = IvaliceBD::connectDB();
        $borradoPersonaje = "DELETE FROM personajes WHERE idPersonaje=\"".$this->idPersonaje."\"";
        $borradoEstadisticas = "DELETE FROM estadisticas WHERE idPersonaje=\"".$this->idPersonaje."\"";
        $conexion->exec($borradoPersonaje);
        $conexion->exec($borradoEstadisticas);
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

    /**
     * Get the value of xp
     */ 
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set the value of xp
     *
     * @return  self
     */ 
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }
}

?>