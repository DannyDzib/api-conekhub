<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/api/usuarios', function(Request $request, Response $response){
    $query = 'SELECT id_usuario, nombre, correo FROM usuarios';

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

$app->get('/api/usuario/{id}/carrera', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    
    $query = "SELECT U.id_usuario, C.carrera 
    FROM usuarios U
    INNER JOIN carreras C ON U.id_carrera = C.id_carrera AND U.id_usuario = '$id'";

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


$app->get('/api/usuario/{id}/escuela', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    
    $query = "SELECT U.id_usuario, E.escuela 
    FROM usuarios U
    INNER JOIN escuelas E ON U.id_escuela = E.id_escuela AND U.id_usuario = '$id'";

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


$app->get('/api/grados', function(Request $request, Response $response){
    $query = 'SELECT * FROM grados_escolares';

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

$app->post('/api/usuario/registrar', function(Request $request, Response $response){

    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $correo = $request->getParam('correo');
    $pass = $request->getParam('pass');
    $id_escuela = $request->getParam('id_escuela');
    $id_carrera = $request->getParam('id_carrera');
    $id_grado = $request->getParam('id_grado');
    
    $query = "INSERT INTO 
        usuarios(
            id_usuario,
            nombre,
            apellidos,
            correo,
            pass,
            id_escuela,
            id_carrera,
            id_grado
        ) 
    VALUES (
        NULL,
        :nombre, 
        :apellidos, 
        :correo, 
        :pass, 
        :id_escuela, 
        :id_carrera, 
        :id_grado
        )";

    try {
        
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':id_escuela', $id_escuela);
        $stmt->bindParam(':id_carrera', $id_carrera);
        $stmt->bindParam(':id_grado', $id_grado);
        $stmt->execute();

        $msg = '{"message: "Succes"}';

        echo $msg;

    } catch(PDOException $e) {
        echo '
            { "error": "message": "' . $e->getMessage().'"}';
    }
    
});
