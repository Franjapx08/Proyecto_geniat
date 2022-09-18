<?php

require __DIR__ . '/../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Autenticacion {

    public $private_key;
    public $config_JWT;

    public function __construct() {
        $this->private_key = 'keySecret';
        $this->config_JWT = 'HS256';
    }

    public function jwtEnconde($id, $correo){
        /* token de autenticacion */
        $time = time();
        $token = array(
            'iat' => $time, /* tiempo en el que inicia el token */
            'exp' => $time + (60*60*24),
            'data' => [
                'id' => $id,
                'correo' => $correo
            ]
        );
        $token = JWT::encode($token, $this->private_key, $this->config_JWT);
        return $token;
    }
    
    public function jwtDecode($token){
        /* token decode */
        $decode = JWT::decode($token, new Key($this->private_key, $this->config_JWT));
        return $decode;
    }
}