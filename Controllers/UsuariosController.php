<?php

require_once 'Models/Usuarios.php';
require_once 'Models/Roles.php';
require_once 'Models/Autenticacion.php';
//require_once 'Models/Permisos.php';
require_once 'Helpers/ResponseJson.php'; 

class UsuariosController{

    public $modelo_usuarios;
    public $modelo_roles;
    public $response_json;
    public $regex_correo;
    public $modelo_auth;

    public function __construct() {
        $this->modelo_usuarios = new Usuarios();
        $this->modelo_roles = new Roles();
        $this->modelo_auth = new Autenticacion();
        //test
        //$this->modelo_permisos = new Permisos();
        $this->response_json = new ResponseJson();
        $this->regex_correo = '/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/';
    }

    public function login($correo, $pass){
        /* validar campos */
        if(!$correo){
            return $this->response_json::error("Es necesario el campo correo", 400);
        }
        if(!$pass){
            return $this->response_json::error("Es necesario el campo password", 400);    
        }
        if(!preg_match($this->regex_correo, $correo)){
            return $this->response_json::error("Correo invalido", 400);    
        }
        /* consultar usuarios */
        $usuario = $this->modelo_usuarios->login($correo, sha1($pass));
        if(count($usuario) > 0){
            $respuesta = $this->response_json::data($usuario, 200);
            //$respuesta = $this->modelo_permisos->getPermisos($usuario[0]['id']);
            $token = $this->modelo_auth->jwtEnconde($usuario[0]['id'], $usuario[0]['correo']);
            /* decodificar token */
            $token_decode = $this->modelo_auth->jwtDecode($token);
            /* guardar token al usuario */
            $usuario = $this->modelo_usuarios->updateToken($usuario[0]['id'], $token, $token_decode->exp);
        }else{
            $respuesta = $this->response_json::error("No se encontraron resultados", 400, "Correo o contraseña incorrectos");
        }
        
        return $token;
    }

    public function registro($nombre, $apellido, $correo, $pass, $rol){
        /* validar datos recibidos para el registro */
        if(!$nombre){
            return $this->response_json::error("Es necesario el campo nombre", 400);
        }
        if(!$apellido){
            return $this->response_json::error("Es necesario el campo apellido", 400);
        }
        if(!$correo){
            return $this->response_json::error("Es necesario el campo correo", 400);
        }
        if(!$pass){
            return $this->response_json::error("Es necesario el campo password", 400);    
        }
        if(!preg_match($this->regex_correo, $correo)){
            return $this->response_json::error("Correo invalido", 400);    
        }
        /* consultar usuarios */
        $usuario_registro = $this->modelo_usuarios->getUsuario($correo);
        if(count($usuario_registro) > 0){
            return $this->response_json::error("El correo que intenta registrar, ya se encuentra en uso", 400);
        }
        /* consultar rol */
        $rol = $this->modelo_roles->getRol($rol);
        if(count($rol) == 0){
            return $this->response_json::error("El rol que intenta asociar, no existe", 400);
        }
        /* registrar usuario */
        $usuario_registro = $this->modelo_usuarios->registro($nombre, $apellido, $correo, sha1($pass));
        /* obtener datos del usuario registrado */
        $usuario_registro = $this->modelo_usuarios->getUsuario($correo);
        /* asociar usuario rol */
        $usuario_rol = $this->modelo_roles->asociarRol($usuario_registro[0]['id'], $rol[0]['id']);
        /* si fue registrado y asociado un rol correctamente */
        $respuesta = $this->response_json::data($usuario_registro, 200);
        return $respuesta;
    }

    public function logout($token){
        /* decodificar token */
        $token_decode = $this->modelo_auth->jwtDecode($token);
        /* buscar usuario token */
        $usuario = $this->modelo_usuarios->getUsuario($token_decode->data->correo);
        /* eliminar token de sesion */
        $usuario = $this->modelo_usuarios->updateToken($usuario[0]['id'], null, null);
        return $this->response_json::msg("Cerro sesión correctamente", 200);
    }

}