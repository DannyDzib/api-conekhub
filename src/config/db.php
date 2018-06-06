<?php
    class db{
        // Properties
        private $dbhost = 'localhost';
        private $dbname = 'conekhub_migration_test';
        private $dbuser = 'root';
        private $dbpass = '_19Mofeta84';
        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname; charset=utf8";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }

?>