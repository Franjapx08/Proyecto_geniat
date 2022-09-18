<?php

include_once 'Conexion.php';

class Roles{

    public $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function getRol($rol){
        $query = $this->conexion->getQuery("SELECT * FROM roles WHERE rol = '".$rol."';");
        return $query;
    }

    public function asociarRol($usuario_id, $rol_id){
        $query = $this->conexion->runQuery("INSERT INTO usuarios_roles (usuario_id, rol_id)
        VALUES ('".$usuario_id."', '".$rol_id."');");
        return $query;
    }
    

}