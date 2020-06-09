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
    private $xpNecesaria;

    /**
     * Class constructor.
     */
    public function __construct($idPersonaje, $nombre, $idClase, $nivel, $foto, $xp, $nick_usuario, $xpNecesaria)
    {
        $this->idPersonaje = $idPersonaje;
        $this->nombre = $nombre;
        $this->idClase = $idClase;
        $this->nivel = $nivel;
        $this->foto = $foto;
        $this->xp = $xp;
        $this->nick_usuario = $nick_usuario;
        $this->xpNecesaria = $xpNecesaria;
    }

    // Esta función inserta el personaje en la bd y tras ello, sus estadísticas iniciales
    public function insertarPersonaje($vida, $atk, $def, $magia, $velocidad, $pm, $ph){
        $conexion = IvaliceBD::connectDB();
        // Inserción de personaje en la BD
        $insertarPersonaje = "INSERT INTO personajes (idPersonaje, Nombre, idClase, Nivel, foto, xp, nick_usuario, xpNecesaria) VALUES ('$this->idPersonaje', '$this->nombre', '$this->idClase', $this->nivel, '$this->foto', '$this->xp', '$this->nick_usuario', '$this->xpNecesaria')";
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
            $personajes[] = new Personaje($personaje->idPersonaje, $personaje->Nombre, $personaje->idClase, $personaje->Nivel, $personaje->foto, $personaje->xp, $personaje->nick_usuario, $personaje->xpNecesaria);
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

        $personaje = new Personaje($ultimoPersonaje->idPersonaje, $ultimoPersonaje->Nombre, $ultimoPersonaje->idClase, $ultimoPersonaje->Nivel, $ultimoPersonaje->foto, $ultimoPersonaje->xp, $ultimoPersonaje->nick_usuario, $ultimoPersonaje->xpNecesaria);
        return $personaje;
    }

    public static function getPersonajeById($idPersonaje){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT * FROM personajes WHERE idPersonaje=\"".$idPersonaje."\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $personaje = new Personaje($registro->idPersonaje, $registro->Nombre, $registro->idClase, $registro->Nivel, $registro->foto, $registro->xp, $registro->nick_usuario, $registro->xpNecesaria);
        
        return $personaje;
    }

    public static function modificarNick_usuario($nickAntiguo, $nuevoNick){
        $conexion = IvaliceBD::connectDB();
        $personajes = Personaje::getPersonajesByNick($nickAntiguo);
    
        $modificarNick = "UPDATE personajes SET nick_usuario='".$nuevoNick."' WHERE nick_usuario='".$nickAntiguo."';";
        $conexion->exec($modificarNick);
    }

    public function borrarPersonaje(){
        $conexion = IvaliceBD::connectDB();
        $borradoPersonaje = "DELETE FROM personajes WHERE idPersonaje=\"".$this->idPersonaje."\"";
        $borradoEstadisticas = "DELETE FROM estadisticas WHERE idPersonaje=\"".$this->idPersonaje."\"";
        $conexion->exec($borradoPersonaje);
        $conexion->exec($borradoEstadisticas);
    }

    public function aumentarNivel($xp){
        $conexion = IvaliceBD::connectDB();
        $xp = $this->xp + $xp;

        if($this->xpNecesaria > $xp){

            $modificarXP = "UPDATE personajes SET xp='".$xp."' WHERE idPersonaje='".$this->idPersonaje."';";

        }else if($this->xpNecesaria == $xp){
            Estadisticas::subirNivel($this->idPersonaje);
            $nuevoNivel = $this->nivel + 1;
            $xpPersonaje = 0;

            $porcentajeAumento = ($this->xpNecesaria*40) / 100;
            $xpResultante = $porcentajeAumento + $this->xpNecesaria;
            $modificarXP = "UPDATE personajes SET nivel='".$nuevoNivel."', xp='".$xpPersonaje."', xpNecesaria='".$xpResultante."' WHERE idPersonaje='".$this->idPersonaje."';";
            
        }else{
            $diferencia = $xp - $this->xpNecesaria;
            $nuevoNivel = $this->nivel + 1;
    
            Estadisticas::subirNivel($this->idPersonaje);

            $porcentajeAumento = ($this->xpNecesaria*40) / 100;
            $xpNecesaria = $porcentajeAumento + $this->xpNecesaria;
            
            $modificarXP = "UPDATE personajes SET nivel='".$nuevoNivel."', xp='".$diferencia."', xpNecesaria='".$xpNecesaria."' WHERE idPersonaje='".$this->idPersonaje."';";
            
        }
        
        $conexion->exec($modificarXP);
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

    /**
     * Get the value of xpNecesaria
     */ 
    public function getXpNecesaria()
    {
        return $this->xpNecesaria;
    }

    /**
     * Set the value of xpNecesaria
     *
     * @return  self
     */ 
    public function setXpNecesaria($xpNecesaria)
    {
        $this->xpNecesaria = $xpNecesaria;

        return $this;
    }
}

?>