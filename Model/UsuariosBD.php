<?php

abstract class UsuariosBD{
    public static function connectDB()
    {
        try{
            $conexion = new PDO("mysql:host=localhost;dbname=ivalice", "root", "");  
        }catch(PDOException $e){
            echo "No se ha podido conectar con la base de datos";
        }
        return $conexion;
    }
}
?>