# Proyecto API RESTful

# Paso 1 - Construir imagenes
    docker-compose build
# Paso 2 - Levantar contenedores
    docker-compose up -d
# Paso 3 - Instalar dependecia composer
    docker-compose exec {nombre_contenedor_app} composer install
# Paso 4 - Conectar a base de datos
    Con software administrador de base de datos: 
        Host: localhost
        Port: 3307
        User: root
        Pass: root
    Desde consola
        colocarse dentro del contenedor de mysql: docker-compose exec mysql bash
        una ves dentro del contenedor de mysql: mysql -h 127.0.0.1 -P 3306 -u root -p
# Paso 5 - Montar bd (incluida en repositorio)

# Puertos para conexiones
    mysql -> localhost 3307
    api -> la api corre sobre el puerto 9000

# Rutas para consumir en local (colección postman incluida en repositorio)
    # El token generado por la api debe ser enviada a traves del método Bearer Token
    # Usuarios
        - Login: POST http://localhost:9000/login
            correo: xxxxx
            password: xxxxx
        - Registro: POST http://localhost:9000/registro
            nombre: xxxxx
            apellido: xxxxx
            correo: xxxxx
            password: xxxx
            rol: [basico, medio, medioAlto, altoMedio, alto]
        - Logout: GET http://localhost:9000/logout
    # Publicaciones
        - Consulta de publicaciones: GET http://localhost:9000/publicaciones
        - Creación de publicación: POST http://localhost:9000/publicaciones
        - Actualización de publicación: PUT http://localhost:9000/publicaciones/{id}
        - Eliminación de publicación: DELETE http://localhost:9000/publicaciones/{id}



