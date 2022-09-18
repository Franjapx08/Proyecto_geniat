<?php

include_once 'Conexion.php';

class Permisos{

    public $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function getPermisos($usuario_id){
        $query = $this->conexion->getQuery("SELECT r.id, r.rol, p.id, p.permiso
        FROM roles r
        JOIN roles_permisos rp ON r.id = rp.rol_id
        JOIN permisos p ON p.id = rp.permiso_id
        JOIN usuarios_roles ur ON r.id = ur.rol_id AND ur.usuario_id = '".$usuario_id."'
        ORDER BY r.id;");
        return $query;
    }
    
}