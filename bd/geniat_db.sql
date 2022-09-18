use geniat_db;

CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `apellido` varchar(100) NOT NULL,
    `correo` varchar(100) NOT NULL,
    `password` varchar(100) NOT NULL,
    `token` text NULL,
    `token_exp` text NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `correo` (`correo`)
);

CREATE TABLE IF NOT EXISTS `roles` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rol` varchar(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `rol` (`rol`)
);

INSERT INTO geniat_db.roles (rol) VALUES ('basico');
INSERT INTO geniat_db.roles (rol) VALUES ('medio');
INSERT INTO geniat_db.roles (rol) VALUES ('medioAlto');
INSERT INTO geniat_db.roles (rol) VALUES ('altoMedio');
INSERT INTO geniat_db.roles (rol) VALUES ('alto');

CREATE TABLE IF NOT EXISTS `usuarios_roles` (
    `id` int NOT NULL AUTO_INCREMENT,
    `usuario_id` int NOT NULL,
    `rol_id` int NOT NULL,
    CONSTRAINT fk_usuario_rol
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_rol_usuario
    FOREIGN KEY (rol_id) REFERENCES roles (id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `permisos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `permiso` varchar(100) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `permiso` (`permiso`)
);

INSERT INTO geniat_db.permisos (permiso) VALUES ('acceso');
INSERT INTO geniat_db.permisos (permiso) VALUES ('consulta');
INSERT INTO geniat_db.permisos (permiso) VALUES ('agregar');
INSERT INTO geniat_db.permisos (permiso) VALUES ('actualizar');
INSERT INTO geniat_db.permisos (permiso) VALUES ('eliminar');

CREATE TABLE IF NOT EXISTS `roles_permisos` (
    `id` int NOT NULL AUTO_INCREMENT,
    `rol_id` int NOT NULL,
    `permiso_id` int NOT NULL,
    CONSTRAINT fk_rol_permiso
    FOREIGN KEY (rol_id) REFERENCES roles (id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_permiso_rol
    FOREIGN KEY (permiso_id) REFERENCES permisos (id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (`id`)
);

INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (1, 1); /* rol basico => acceso */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (2, 1); /* rol medio => acceso */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (2, 2); /* rol medio => consulta */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (3, 1); /* rol medioAlto => acceso */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (3, 3); /* rol medioAlto => agregar */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (4, 1); /* rol altoMedio => acceso */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (4, 2); /* rol altoMedio => consulta */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (4, 3); /* rol altoMedio => agregar */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (4, 4); /* rol altoMedio => actualizar */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (5, 1); /* rol altoMedio => acceso */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (5, 2); /* rol altoMedio => consulta */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (5, 3); /* rol altoMedio => agregar */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (5, 4); /* rol altoMedio => actualizar */
INSERT INTO geniat_db.roles_permisos (rol_id, permiso_id) VALUES (5, 5); /* rol altoMedio => eliminar */

CREATE TABLE IF NOT EXISTS `publicaciones` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `titulo` varchar(100) NOT NULL,
    `descripcion` text NOT NULL,
    `fecha_creacion` date NOT NULL,
    `usuario_id` int NOT NULL,
    `created_at` timestamp null,
    `updated_at` timestamp null,
    `delete_at` timestamp null,
    CONSTRAINT fk_usuario_publicacion
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (`id`)
);