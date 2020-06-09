<?php 

require_once "../Model/IvaliceBD.php";

class HabilidadesEnemigos{

    private $nombreEnemigo;
    private $nombreHabilidad;
    private $dmg;
    private $turno;
    /**
     * Class constructor.
     */
    public function __construct($nombreEnemigo, $nombreHabilidad, $dmg, $turno)
    {
        $this->nombreEnemigo = $nombreEnemigo;
        $this->nombreHabilidad = $nombreHabilidad;
        $this->dmg = $dmg;
        $this->turno = $turno;
    }

    public static function getHabilidadesByNombre($nombreEnemigo){
        $conexion = IvaliceBD::connectDB();
        $registros = "SELECT * FROM habilidades_enemigos WHERE nombreEnemigo=\"".$nombreEnemigo."\"";
        $consulta = $conexion->query($registros);
        $habilidades = [];

        while ($habilidad = $consulta->fetchObject()) {
            $habilidades[] = new HabilidadesEnemigos($habilidad->nombreEnemigo, $habilidad->nombreHabilidad, $habilidad->dmg, $habilidad->turno);
        }

        return $habilidades;
    }

    public function getNombreEnemigo()
    {
        return $this->nombreEnemigo;
    }

    public function getNombreHabilidad()
    {
        return $this->nombreHabilidad;
    }

    public function getDmg()
    {
        return $this->dmg;
    }

    public function getTurno()
    {
        return $this->turno;
    }
}

?>