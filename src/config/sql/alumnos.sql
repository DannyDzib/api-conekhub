CREATE TABLE usuarios (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(40) NOT NULL,
    apellidos VARCHAR(40) NOT NULL,
    correo VARCHAR(55) NOT NULL,
    pass VARCHAR(20) NOT NULL,
    id_escuela INT, 
    id_carrera INT,
    id_grado INT,
    PRIMARY KEY (id_usuario),
    FOREIGN KEY (id_escuela) REFERENCES escuelas(id_escuela),
    FOREIGN KEY (id_carrera) REFERENCES carreras(id_carrera),
    FOREIGN KEY (id_grado) REFERENCES grados_escolares(id_grado)
);