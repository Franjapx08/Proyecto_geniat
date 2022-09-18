<?php

require_once 'Models/Publicaciones.php';
require_once 'Models/Usuarios.php';
require_once 'Models/Autenticacion.php';
require_once 'Helpers/ResponseJson.php';

class PublicacionesController{

    public $modelo_publicaciones;
    public $modelo_usuarios;
    public $modelo_auth;

    public function __construct() {
        $this->modelo_publicaciones = new Publicaciones();
        $this->modelo_usuarios = new Usuarios();
        $this->modelo_auth = new Autenticacion();
        $this->response_json = new ResponseJson();
    }

    public function getPublicaciones(){
        $publicaciones = $this->modelo_publicaciones->getPublicaciones();
        return $this->response_json::data($publicaciones, 200);
    }

    public function createPublicacion($titulo, $descripcion, $token){
        /* validar campos */
        if(!$titulo){
            return $this->response_json::error("Es necesario el campo titulo", 400);
        }
        if(!$descripcion){
            return $this->response_json::error("Es necesario el campo des$descripcion", 400);
        }
        /* decodificar token */
        $token_decode = $this->modelo_auth->jwtDecode($token);
        /* usuario crea */
        $usuario = $this->modelo_usuarios->getUsuario($token_decode->data->correo);
        /* fecha creacion */
        date_default_timezone_set('America/Monterrey');
        $date = date('Y-m-d', time());
        $create_at = date('Y-m-d h:i:s', time());
        $publicaciones = $this->modelo_publicaciones->createPublicacion($titulo, $descripcion, $date, $usuario[0]['id'], $create_at);
        return $this->response_json::msg("Publicación creada correctamente", 200);
    }

    public function updatePublicacion($titulo, $descripcion, $publicacion_id){
        /* validar campos */
        if(!$titulo && !$descripcion){
            return $this->response_json::error("Es necesario colocar almenos un campo a editar", 400);
        }
        /* validar que no este eliminada la publicacion */
        $publicacion = $this->modelo_publicaciones->getPublicacion($publicacion_id);
        if(count($publicacion) == 0){
            return $this->response_json::error("No se encontro la publicación", 400);
        }
        $titulo = $titulo == null ? $publicacion[0]['titulo'] : $titulo;
        $descripcion = $descripcion == null ? $publicacion[0]['descripcion'] : $descripcion;
        /* fecha update */
        date_default_timezone_set('America/Monterrey');
        $updated_at = date('Y-m-d h:i:s', time());
        $publicaciones = $this->modelo_publicaciones->updatePublicacion($publicacion_id, $titulo, $descripcion, $updated_at);
        return $this->response_json::msg("Publicación modificada correctamente", 200);        
    }

    public function deletePublicacion($publicacion_id){
        /* validar que no este eliminada la publicacion */
        $publicacion = $this->modelo_publicaciones->getPublicacion($publicacion_id);
        if(count($publicacion) == 0){
            return $this->response_json::error("No se encontro la publicación", 400);
        }
        /* fecha delete */
        date_default_timezone_set('America/Monterrey');
        $delete_at = date('Y-m-d h:i:s', time());
        $publicaciones = $this->modelo_publicaciones->deletePublicacion($publicacion_id, $delete_at);
        return $this->response_json::msg("Publicación eliminada correctamente", 200);        
    }

}