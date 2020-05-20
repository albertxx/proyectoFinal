<?php 

require_once "../Model/IvaliceBD.php";
require_once "../Model/Personaje.php";

class Usuario{
    private $nick;
    private $pwd;
    private $nombre;
    private $apellidos;
    private $correo;
    private $pts;

    /**
     * Class constructor.
     */
    public function __construct($nick, $pwd, $nombre, $apellidos, $correo, $pts){

        $this->nick = $nick;
        $this->pwd = $pwd;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->pts = $pts;
    }


    // Registrar usuarios en la bd
    function registarUsuario(){
        $conexion = IvaliceBD::connectDB();
        $insertarUsuario = "INSERT INTO usuarios (nick, pwd, nombre, apellidos, email, pts) VALUES ('$this->nick', '$this->pwd', '$this->nombre', '$this->apellidos', '$this->correo', 0)";
        $conexion->exec($insertarUsuario);
    }

    // Modificar información del usuario en la bd
    // Recibe el antiguo nick en caso de ser modificado
    function modificarUsuario($nickAntiguo){
        $conexion = IvaliceBD::connectDB();

        Personaje::modificarNick_usuario($nickAntiguo, $this->nick);

        $modificarUsuario = "UPDATE usuarios SET nick='".$this->nick."', pwd='".$this->pwd."', nombre='".$this->nombre."', apellidos='".$this->apellidos."', email='".$this->correo."', pts='".$this->pts."' WHERE nick='".$nickAntiguo."';";
        $conexion->exec($modificarUsuario);


    }
    
    // Recoger todos los usuarios de la base de datos
    public static function getUsuarios(){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * from usuarios";
        $consulta = $conexion->query($registros);
        $usuarios = [];

        while ($usuario = $consulta->fetchObject()) {
            $usuarios[] = new Usuario($usuario->nick, $usuario->pwd, $usuario->nombre, $usuario->apellidos, $usuario->email, $usuario->pts);
        }

        return $usuarios;
    }

    // Recoger un usuario de la base de datos
    public static function getUsuarioById($nick){
        $conexion = IvaliceBD::connectDB();
        $seleccion = "SELECT nick, pwd, nombre, apellidos, email, pts FROM usuarios WHERE nick=\"".$nick."\"";
        $consulta = $conexion->query($seleccion);
        $registro = $consulta->fetchObject();
        $usuario = new Usuario($registro->nick, $registro->pwd, $registro->nombre, $registro->apellidos, $registro->email, $registro->pts);
    
        return $usuario;
    }

    /**
     * Get the value of nick
     */ 
    public function getNick()
    {
        return $this->nick;
    }

    /**
     * Set the value of nick
     *
     * @return  self
     */ 
    public function setNick($nick)
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * Get the value of pwd
     */ 
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * Set the value of pwd
     *
     * @return  self
     */ 
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;

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
     * Get the value of apellidos
     */ 
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */ 
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of correo
     */ 
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set the value of correo
     *
     * @return  self
     */ 
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get the value of pts
     */ 
    public function getPts()
    {
        return $this->pts;
    }

    /**
     * Set the value of pts
     *
     * @return  self
     */ 
    public function setPts($pts)
    {
        $this->pts = $pts;

        return $this;
    }
}

?>