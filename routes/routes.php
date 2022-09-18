<?php
require_once 'Helpers/ResponseJson.php'; 
require_once 'Helpers/AuthValidation.php';
require_once 'config/ConfigPut.php';

/* obtener nombre de la url despues de / */
$routes_array = explode("/", $_SERVER['REQUEST_URI']);
/* eliminar valores vacios */
$routes_array = array_filter($routes_array);
/* invocar helpers */
$auth_validation = new AuthValidation(); 
$responseJson = new ResponseJson();
/* si no se encuentra una ruta */
if(count($routes_array) == 0){
    $response = $responseJson::error("Not found", 200);
}
/* validar que la url contenga uno o maximo dos parametros y se use un metodo http */
if(count($routes_array) == 1 || count($routes_array) == 2 && isset($_SERVER['REQUEST_METHOD'])){
/*     echo 'aca';
    return; */
    /* Registro de usuario */
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $routes_array[1] == "registro"){
        require_once 'Controllers/UsuariosController.php';
        $usuario = new UsuariosController();
        $response = $usuario->registro($_POST['nombre'], $_POST['apellido'], $_POST['correo'], $_POST['password'], $_POST['rol']);
        echo json_encode($response);
        return;
    }
    /* Login */
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $routes_array[1] == "login"){
        require_once 'Controllers/UsuariosController.php';
        $usuario = new UsuariosController();
        $response = $usuario->login($_POST['correo'], $_POST['password']);
        echo json_encode($response);
        return;
    }
    /* validar token */
  /*   echo $auth_validation::validate();
    return; */
    if($auth_validation::validate()){
        /* Obtener Publicaciones */
        if($_SERVER['REQUEST_METHOD'] == 'GET' && $routes_array[1] == "publicaciones"){
            require_once 'Controllers/PublicacionesController.php';
            $publicaciones = new PublicacionesController();
            $response = $publicaciones->getPublicaciones();
            echo json_encode($response);
            return;
        }
        /* Crear Publicaciones */
        if($_SERVER['REQUEST_METHOD'] == 'POST' && $routes_array[1] == "publicaciones"){
            require_once 'Controllers/PublicacionesController.php';
            $publicaciones = new PublicacionesController();
            $response = $publicaciones->createPublicacion($_POST['titulo'], $_POST['descripcion'], $auth_validation::validate());
            echo json_encode($response);
            return;
        }
        /* Editar Publicaciones */
        if($_SERVER['REQUEST_METHOD'] == 'PUT' && $routes_array[1] == "publicaciones" && $routes_array[2]){
            require_once 'Controllers/PublicacionesController.php';
            $config_put = new ConfigPut();
            $_PUT = $config_put::getDataFromPut(json_encode(file_get_contents("php://input")));
            $usuario = new PublicacionesController();
            $response = $usuario->updatePublicacion($_PUT['titulo'], $_PUT['descripcion'], $routes_array[2]);
            echo json_encode($response);
            return;
        }
        /* Eliminar Publicaciones */
        if($_SERVER['REQUEST_METHOD'] == 'DELETE' && $routes_array[1] == "publicaciones" && $routes_array[2]){
            require_once 'Controllers/PublicacionesController.php';
            $publicaciones = new PublicacionesController();
            $response = $publicaciones->deletePublicacion($routes_array[2]);
            echo json_encode($response);
            return;
        }
        /* Logout */
        if($_SERVER['REQUEST_METHOD'] == 'GET' && $routes_array[1] == "logout"){
            require_once 'Controllers/UsuariosController.php';
            $usuario = new UsuariosController();
            $response = $usuario->logout($auth_validation::validate());
            echo json_encode($response);
            return;
        }
    }else{
        /* error en token */
        $response = $responseJson::error("token incorrecto", 401);
        echo json_encode($response);
        return;
    }
}else{
    /* ruta no identificada */
    $response = $responseJson::error("Not found", 200);
    echo json_encode($response);
    return;
}

