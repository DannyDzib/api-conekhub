use conekhub_test;

CREATE TABLE `habilidades` (
    `id_habilidad` int NOT NULL AUTO_INCREMENT,
    `habilidad` varchar(100) NOT NULL,
    PRIMARY KEY (`id_habilidad`)
);


use conekhub_test;

CREATE TABLE `usuario_has_seguidores` (
  `id_usuario` int,
  `id_habilidad` int,
  FOREIGN KEY (`id_usuario`) REFERENCES usuarios(`id_usuario`),
  FOREIGN KEY (`id_habilidad`) REFERENCES seguidores(`id_habilidad`)
);

use conekhub_test;


CREATE TABLE friendlist (               
    id_usuario int PRIMARY KEY,             
    id_usuario_FK int PRIMARY KEY,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_usuario_FK) REFERENCES usuarios(id_usuario)
);  


SELECT habilidad from usuario_has_habilidades Uh
INNER JOIN usuarios U
ON Uh.id_habilidad = U.id_habilidad;
