<?php

abstract class IvaliceBD{
    public static function connectDB()
    {
        try{
            $conexion = new PDO("mysql:host=localhost;dbname=ivalice;charset=utf8", "root", "");
            // $conexion->set_charset("utf8"); 
        }catch(PDOException $e){
            echo "No se ha podido conectar con la base de datos";
        }
        return $conexion;
    }
}
?>