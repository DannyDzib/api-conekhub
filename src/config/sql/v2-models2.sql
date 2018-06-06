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

CREATE TABLE estudent (
    student INT,
    school INT, 
    career INT, 
    grade INT,
    FOREIGN KEY (student) REFERENCES users(id),
    FOREIGN KEY (school) REFERENCES schools(id_school),
    FOREIGN KEY (career) REFERENCES careers(id_career),
    FOREIGN KEY (grade) REFERENCES school_grades(id_grade)
);