--
-- Table structure for table `User`
--

CREATE TABLE users (
    id INT NOT NULL auto_increment PRIMARY KEY,
    firstName VARCHAR(70) NOT NULL, 
    lastName VARCHAR(70) NOT NULL,
    pass VARCHAR(32) NOT NULL,
    rol VARCHAR(10) NOT NULL
);

ALTER TABLE users ADD email VARCHAR(255) NOT NULL AFTER lastName;

--
-- Table structure for table `Escuelas`
--

CREATE TABLE schools (
  id_school int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nameSchool varchar(200) NOT NULL,
  shortName varchar(10)
);


--
-- Table structure for table `Carreras`
--

CREATE TABLE careers (
  id_career int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nameCareer varchar(200) NOT NULL,
  school int(11) NOT NULL,
  FOREIGN KEY (school) REFERENCES schools(id_school)
);

--
-- Table structure for table `Grados`
--


CREATE TABLE school_grades(
  id_grade int NOT NULL,
  grade varchar(12) not NULL,
  num int(2) not NULL
);

--
-- Table structure for table `Estudiante`
--
use conekhub_migration_test;

CREATE TABLE estudent(
    id int NOT NULL PRIMARY KEY,
    id_school int NOT NULL, 
    id_career int NOT NULL,
    FOREIGN KEY (id) REFERENCES users(id),
    FOREIGN KEY (id_school) REFERENCES schools(id_school),
    FOREIGN KEY (id_career) REFERENCES careers(id_career)
);


CREATE TABLE recluter(
    id int NOT NULL PRIMARY KEY,
    empresa varchar(200) NOT NULL,
    FOREIGN KEY (id) REFERENCES users(id)
);


jj


ALTER TABLE estudent
ADD CONSTRAINT id_grade
FOREIGN KEY (id_grade) REFERENCES school_grades(id_grade);