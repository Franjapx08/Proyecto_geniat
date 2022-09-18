<?php

include_once 'Conexion.php';

class Publicaciones{

    public $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function getPublicaciones(){
        $query = $this->conexion->getQuery("SELECT p.id, p.titulo, p.descripcion, p.fecha_creacion, u.nombre, u.apellido, r.rol
        FROM publicaciones p
        JOIN geniat_db.usuarios u ON u.id = p.usuario_id
        JOIN geniat_db.usuarios_roles ur ON u.id = ur.usuario_id
        JOIN roles r ON r.id = ur.rol_id
        WHERE p.delete_at IS NULL;");
        return $query;
    }

    public function getPublicacion($publicacion_id){
        $query = $this->conexion->getQuery("SELECT * FROM `publicaciones` WHERE id = '".$publicacion_id."' AND delete_at IS NULL;");
        return $query;
    }
    
    public function createPublicacion($titulo, $descripcion, $date, $usuario_id, $create_at){
        $query = $this->conexion->runQuery("INSERT INTO `publicaciones` (titulo, descripcion, fecha_creacion, usuario_id, created_at, updated_at, delete_at)
        VALUES ('".$titulo."', '".$descripcion."', '".$date."', '".$usuario_id."', '".$create_at."', null, null);");
        return $query;
    }

    public function updatePublicacion($publicacion_id, $titulo, $descripcion, $updated_at){
        $query = $this->conexion->runQuery("UPDATE `publicaciones` SET titulo = '".$titulo."', descripcion = '".$descripcion."', updated_at = '".$updated_at."' WHERE id = '".$publicacion_id."';");
        return $query;
    }

    public function deletePublicacion($publicacion_id, $delete_at){
        $query = $this->conexion->runquery("UPDATE `publicaciones` SET delete_at = '".$delete_at."' WHERE id = '".$publicacion_id."';");
    }

}