<?php

include_once 'Conexion.php';

class Usuarios{

    public $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function login($correo, $pass){
        $query = $this->conexion->getQuery("SELECT u.id as id, u.nombre, u.apellido, u.correo, r.rol
        FROM usuarios u
        JOIN usuarios_roles ur ON u.id = ur.usuario_id
        JOIN roles r on ur.rol_id = r.id
        WHERE u.correo = '".$correo."' AND u.password = '".$pass."';");
        return $query;
    }

    public function registro($nombre, $apellido, $correo, $pass){
        $query = $this->conexion->runQuery("INSERT INTO `usuarios` (nombre, apellido, correo, password)
        VALUES ('".$nombre."', '".$apellido."', '".$correo."', '".$pass."');");
        return $query;
    }

    public function getUsuario($correo){
        $query = $this->conexion->getQuery("SELECT * FROM `usuarios` WHERE correo = '".$correo."';");
        return $query;
    }

    public function updateToken($usuario_id, $token, $token_exp){
        $query = $this->conexion->runQuery("UPDATE `usuarios` SET token = '".$token."', token_exp = '".$token_exp."' WHERE id = '".$usuario_id."';");
        return $query;
    }
    

}