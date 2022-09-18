<?php

require_once 'Models/Autenticacion.php';
require_once 'Models/Usuarios.php';

class AuthValidation{

    public static function validate()
    {
        $token = self::getBearerToken();
        if($token){
            /* decode token */
            $modelo_auth = new Autenticacion();
            $token_decode = $modelo_auth->jwtDecode($token);
            /* obtener usuario para validar token */
            $modelo_usuarios = new Usuarios();
            $usuario = $modelo_usuarios->getUsuario($token_decode->data->correo);
            if(count($usuario) > 0){
                /* validar token y token_exp */
                $time = time();
                if($usuario[0]['token'] == $token && $usuario[0]['token_exp'] > $time){
                    return $token;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        return false;
    }
    
    /** 
     * Obtener header Authorization
     * */
    public static function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header
     * */
    public static function getBearerToken() {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}