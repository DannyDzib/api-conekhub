<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/api/escuelas', function(Request $request, Response $response){
    $query = 'SELECT * FROM escuelas';

    try {
        $test = 1;
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        //echo $test; 
        echo json_encode($result);

    } catch(PDOException $e) {
        echo '
            { "error": "message": ' . $e->getMessage().'}';
    }
    
});

$app->get('/api/escuela/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    
    $query = "SELECT * FROM escuelas WHERE id_escuela = '$id' ";

    try {
        
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($result);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "' . $e->getMessage().'"}';
    }
    
});

$app->get('/api/escuela/{id}/carreras', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    
    $query = "SELECT c.carrera FROM carreras c, escuelas es WHERE es.id_escuela = c.id_escuela AND c.id_escuela = '$id'";

    try {
        
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($result);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "' . $e->getMessage().'"}';
    }
    
});

$app->get('/api/carreras', function(Request $request, Response $response){
    
    $query = "SELECT C.carrera, C.id_carrera FROM carreras C, escuelas E WHERE C.id_escuela = E.id_escuela";

    try {
        
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($result);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "' . $e->getMessage().'"}';
    }
    
});