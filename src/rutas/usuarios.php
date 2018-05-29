<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$prefix = '/api/v1';

/////////////////////////////////////
////////////////////////////////////
//-------USERS DATA ENPOINTS------//
///////////////////////////////////
//////////////////////////////////

$app->get($prefix.'/usuarios', function(Request $request, Response $response){
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

$app->get($prefix.'/usuario/{id}/carrera', function(Request $request, Response $response){

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

$app->get($prefix.'/usuario/{id}/escuela', function(Request $request, Response $response){

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

$app->get($prefix.'/usuario/{id}/habilidades', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    
    $query = "SELECT 
    U.habilidad FROM habilidades U 
    INNER JOIN usuario_has_habilidades E 
    ON U.id_habilidad = E.id_habilidad AND E.id_usuario = '$id'";

    try {
        
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        
        echo json_encode($result);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "' . $e->getMessage().'"}';
    }
    
});

$app->post($prefix.'/email/exists', function(Request $request, Response $response){
    
    $email = $request->getParam('email');

    $query = "SELECT U.correo FROM usuarios U WHERE correo = '$email'";


    try {
        $test = 1;
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        $existe = Array('exists' => 'false');
        if($result) {
            $existe = Array('exists' => 'true');
        } 
        $db = null; 
        echo json_encode($existe);

    } catch(PDOException $e) {
        echo '{ "error": "message": ' . $e->getMessage().'}';
    }
    
});

$app->post($prefix.'/email/recluters/exists', function(Request $request, Response $response){
    
    $email = $request->getParam('email');

    $query = "SELECT U.correo FROM reclutadores U WHERE correo = '$email'";


    try {
        $test = 1;
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        $existe = Array('exists' => 'false');
        if($result) {
            $existe = Array('exists' => 'true');
        } 
        $db = null; 
        echo json_encode($existe);

    } catch(PDOException $e) {
        echo '{ "error": "message": ' . $e->getMessage().'}';
    }
    
});

$app->get($prefix.'/habilidades', function(Request $request, Response $response){
    $query = 'SELECT * FROM habilidades';

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

$app->get($prefix.'/grados', function(Request $request, Response $response){
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

$app->post($prefix.'/registrar', function(Request $request, Response $response){

    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $correo = $request->getParam('correo');
    $pass = $request->getParam('pass');
    $id_escuela = $request->getParam('id_escuela');
    $id_carrera = $request->getParam('id_carrera');
    $id_grado = $request->getParam('id_grado');

    $hash = new Hash();
    $passHash = $hash->encryptHash($pass);
    $hash = null;
    
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
        $stmt->bindParam(':pass', $passHash);
        $stmt->bindParam(':id_escuela', $id_escuela);
        $stmt->bindParam(':id_carrera', $id_carrera);
        $stmt->bindParam(':id_grado', $id_grado);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'Usuario Registrado');

        echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

$app->post($prefix.'/registrar/reclutador', function(Request $request, Response $response){

    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $empresa = $request->getParam('empresa');
    $correo = $request->getParam('correo');
    $pass = $request->getParam('pass');

    $hash = new Hash();
    $passHash = $hash->encryptHash($pass);
    $hash = null;

    $query = "INSERT INTO 
        reclutadores (
            id_reclutador, 
            nombre, 
            apellidos, 
            empresa, 
            correo, 
            pass
            ) 
        VALUES 
            (
            NULL, 
            :nombre, 
            :apellidos, 
            :empresa, 
            :correo, 
            :pass
            )";

    try {
        
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':empresa', $empresa);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':pass', $passHash);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'Usuario Registrado');

        echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
    
});

$app->post($prefix.'/session/login', function(Request $request, Response $response){

    $email = $request->getParam('email');
    $pass = $request->getParam('password');

    $hash = new Hash();
    $passHash = $hash->encryptHash($pass);
    $hash = null;

    $query = "SELECT id_usuario, nombre, correo
    FROM usuarios 
    WHERE correo='$email' AND pass='$passHash' 
    UNION 
    SELECT id_reclutador, nombre, correo 
    FROM reclutadores 
    WHERE correo='$email' AND pass='$passHash'";

    //$query = "SELECT id_usuario, nombre, correo FROM usuarios WHERE correo = '$email' AND pass = '$passHash'";

    try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetch(PDO::FETCH_ASSOC);
        $db = null;
        //echo $test; 
        if($result) {
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            array_push($result, ['token' => $token]);
            $session = array('session' => true, 'id_usuario' => $result['id_usuario'] ,'token' => $token);;
        } else {
            $session = array('session' => false, 'message' => 'Credenciales incorrectas', 'type_error' => 'Acceso Denegado');
        }

        echo json_encode($session);

    } catch(PDOException $e) {
        $responseError =  '{ "error": "message": "'.$e->getMessage().'"}';
        echo json_encode($responseError);
    }
    
});


