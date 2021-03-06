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

$app->get($prefix.'/usuario/{id}/perfil', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    
    $query = "SELECT 
    U.habilidad FROM habilidades U 
    INNER JOIN usuario_has_habilidades E 
    ON U.id_habilidad = E.id_habilidad AND E.id_usuario = '$id'";

    $query2 = "SELECT 
    U.puesto, U.empresa, U.fecha_inicial, U.fecha_final FROM usuarios_has_experience U 
    INNER JOIN usuarios E
    ON U.id_usuario = E.id_usuario AND E.id_usuario = '$id'";

    $query3 = "SELECT U.id_usuario, U.nombre, U.apellidos  FROM usuarios U 
    WHERE U.id_usuario = '$id'";

    $query4 = "SELECT E.escuela 
    FROM usuarios U
    INNER JOIN escuelas E ON U.id_escuela = E.id_escuela AND U.id_usuario = '$id'";

    $query5 = "SELECT C.carrera 
    FROM usuarios U
    INNER JOIN carreras C ON U.id_carrera = C.id_carrera AND U.id_usuario = '$id'";

    try {
        
        $db = new db();
        $db = $db->connect();
        $eHabilidades = $db->query($query);
        $eExperiencias = $db->query($query2);
        $eDatos = $db->query($query3);
        $eEscuela = $db->query($query4);
        $eCarrera = $db->query($query5);
        $hab = $eHabilidades->fetchAll(PDO::FETCH_OBJ);
        $exp = $eExperiencias->fetchAll(PDO::FETCH_OBJ);
        $datos = $eDatos->fetch(PDO::FETCH_ASSOC);
        $escuela = $eEscuela->fetch(PDO::FETCH_ASSOC);
        $carrera = $eCarrera->fetch(PDO::FETCH_ASSOC);

        $db = null;

        $redirecTo = 'perfil/estudiante/'.$datos['id_usuario'];
        $datos = array(
            'usuario' => array(
                'nombre' => $datos['nombre'],
                'apellidos' => $datos['apellidos'],
                'UrlProfile' => $redirecTo,
                'escuela' => $escuela['escuela'],
                'carrera' => $carrera['carrera'],
                'skills' => array(
                    'habilidades' => $hab,
                    'experiencia' => $exp
                )
            )
        );

        echo json_encode($datos);

    } catch(PDOException $e) {
        $error = array(
            'error' => $e->getMessage()
        );
        echo json_encode($error);
    }
    
});


$app->post($prefix.'/email/exists', function(Request $request, Response $response){
    
    $email = $request->getParam('email');

    $query = "SELECT U.correo 
    FROM usuarios U WHERE correo = '$email'
    UNION 
    SELECT r.correo 
    FROM reclutadores r WHERE correo = '$email'";


    try {
        $test = 1;
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        $existe = Array('exists' => false);
        if($result) {
            $existe = Array('exists' => true);
        } 
        $db = null; 
        echo json_encode($existe);

    } catch(PDOException $e) {
        echo '{ "error": "message": "' . $e->getMessage().'"}';
    }
    
});

$app->get($prefix.'/usuario/{id}/exists', function(Request $request, Response $response){
    
    $email = $request->getParam('id');

    $query = "SELECT U.id_usuario
    FROM usuarios U WHERE id_usuario = '$email'";


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
        echo '{ "error": "message": "' . $e->getMessage().'"}';
    }
    
});


$app->post($prefix.'/upload/photo', function(Request $request, Response $response){

    $imagen = $request->getParam('imagen');


    define('UPLOAD_DIR', 'images/');
	$img = $_POST['imagen'];
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.jpg';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';



    try {
        
        // $db = new db();
        // $db = $db->connect();
        // $stmt = $db->prepare($query);
        // $stmt->bindParam(':nombre', $nombre);
        // $stmt->bindParam(':apellidos', $apellidos);
        // $stmt->bindParam(':correo', $correo);
        // $stmt->bindParam(':pass', $passHash);
        // $stmt->bindParam(':id_escuela', $id_escuela);
        // $stmt->bindParam(':id_carrera', $id_carrera);
        // $stmt->bindParam(':id_grado', $id_grado);
        // $stmt->execute();

       // $json = Array('status' => 'Succes', 'message' => 'Usuario Registrado');

        // echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": '.$e->getMessage().'}';
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

