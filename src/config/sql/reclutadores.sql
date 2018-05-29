CREATE TABLE reclutadores (
    id_reclutador INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    apellidos VARCHAR(40) NOT NULL,
    empresa VARCHAR(50) NOT NULL,
    correo VARCHAR(55) NOT NULL,
    pass VARCHAR(20) NOT NULL
);