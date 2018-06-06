CREATE TABLE post_users (
    id_publicacion INT NOT NULL PRIMARY KEY,
    contenido varchar(500),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_usuario int NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);


CREATE TABLE post_recluters (
    id_publicacion INT NOT NULL PRIMARY KEY,
    contenido varchar(500),
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_reclutador int NOT NULL,
    FOREIGN KEY (id_reclutador) REFERENCES reclutadores(id_reclutador)
);


SELECT * FROM ( SELECT nombre, 'estudiante' as rol FROM usuarios UNION ALL SELECT nombre, 'reclutador' as rol FROM reclutadores ) as usuarios;