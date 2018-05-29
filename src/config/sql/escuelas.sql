--
-- Table structure for table `estados`
--
use conekhub_test;

CREATE TABLE `escuelas` (
  `id_escuela` int NOT NULL AUTO_INCREMENT,
  `escuela` varchar(100) NOT NULL,
  `matricula` int(11) NOT NULL,
  PRIMARY KEY (`id_escuela`)
);


--
-- Table structure for table `municipios`
--

CREATE TABLE `carreras` (
  `id_carrera` int NOT NULL AUTO_INCREMENT,
  `carrera` varchar(100) NOT NULL,
  `id_escuela` int(11) NOT NULL,
  PRIMARY KEY (`id_carrera`),
  FOREIGN KEY (`id_escuela`) REFERENCES escuelas(`id_escuela`)
);



SELECT u.nombre, e.escuela, c.carrera
FROM usuarios u, escuelas e, carreras c
WHERE (e.id_escuela = c.id_escuela);


SELECT U.nombre, DT.Escuela, DT.Carrera FROM usuarios U
LEFT JOIN
(
    SELECT 
    E.escuela Escuela, 
    C.carrera Carrera
    FROM 
    carreras 
    C 
    INNER JOIN 
    escuelas E 
    ON C.id_escuela = E.id_escuela 
    ORDER BY E.escuela
) ES --Derived Table for inner join
ON DT.id_escuela=U.id_escuela AND DT.id_carrera = U.id_carrera