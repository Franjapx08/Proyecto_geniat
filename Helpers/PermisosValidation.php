<?php

require_once 'Models/Autenticacion.php';
require_once 'Models/Permisos.php';
require_once 'Models/Usuarios.php';

class PermisosValidation{

    public static function comprobarPermisos($token, $accion)
    {
        if($token){
            /* decode token */
            $modelo_auth = new Autenticacion();
            $token_decode = $modelo_auth->jwtDecode($token);
            /* obtener usuario para validar token */
            $modelo_usuarios = new Usuarios();
            $usuario = $modelo_usuarios->getUsuario($token_decode->data->correo);
            /* obtener permisos */
            $modelo_permisos = new Permisos();
            $permisos = $modelo_permisos->getPermisos($usuario[0]['id']);
            $permisos_array = [];
            foreach($permisos as $permiso){
                array_push($permisos_array, $permiso['permiso']);
            }
            if(in_array($accion, $permisos_array)){
                return true;
            }
            return false;        
        }
        return false;
    }
}