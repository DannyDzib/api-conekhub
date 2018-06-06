<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$prefixv2 = '/api/v2';

$app->get($prefixv2.'/users', function(Request $request, Response $response){

    $query = 'SELECT id, firstName, email FROM users';

    try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        //echo $test; 
        echo json_encode($result);

    } catch(PDOException $e) {
        echo '{ "error": "message": "'.$e->getMessage().'"}';
    }
    
});

$app->get($prefixv2.'/users/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $query = "SELECT id, firstName, lastName, email, rol, isActive FROM users WHERE id='$id'";

    try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetch(PDO::FETCH_ASSOC);
        $db = null;
        //echo $test; 

        $res = array(
            "id" => $result["id"],
            "name" => $result["firstName"],
            "last_name" => $result["lastName"],
            "email" => $result["email"],
            "isActive" => $result["isActive"]
        );

        

        echo json_encode($res);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "'.$e->getMessage().'"}';
    }
    
});


$app->post($prefixv2.'/users/new', function(Request $request, Response $response){

    $name = $request->getParam('name');
    $last = $request->getParam('lastname');
    $email = $request->getParam('email');
    $pass = $request->getParam('password');
    $role = $request->getParam('role');
    $status = $request->getParam('status');

    /*
        body 

    {
        "name":""
        "lastname":""
        "email":""
        "password":""
        "role":"",
        "status":""
    }
    */

    $hash = new Hash();
    $passHash = $hash->encryptHash($pass);
    $hash = null;
    
    $query = "INSERT INTO 
        `users` 
        (
            `id`, 
            `firstName`, 
            `lastName`, 
            `email`, 
            `pass`, 
            `rol`,
            `isActive`) VALUES 
            (
            NULL, 
            :name, 
            :lastname, 
            :email, 
            :pass, 
            :role,
            :status)";

    try {
        
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':lastname', $last);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $passHash);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'registered user');
        echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
    
});


$app->post($prefixv2.'/users/login', function(Request $request, Response $response){

      $email = $request->getParam('email');
      $pass = $request->getParam('password');

      $hash = new Hash();
      $passHash = $hash->encryptHash($pass);
      $hash = null;


      $query = "SELECT id, firstName, lastName, email, rol, isActive 
      FROM users 
      WHERE email = '$email' AND pass = '$passHash'";

      try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetch(PDO::FETCH_ASSOC);
        $db = null;

        $name_user = ucwords($result['firstName'].' '.$result['lastName']); 
        //echo $test; 
        if($result) {
            $session = array(
                'session' => true, 
                'id_user' => $result['id'],
                'name' => $name_user,
                'role' => $result['rol'],
                'isActive' => $result['isActive']
            );
        } else {
            $session = array(
                'session' => false, 
                'message' => 'Credenciales incorrectas', 
                'type_error' => 'Acceso Denegado'
            );
        }

        echo json_encode($session);

    } catch(PDOException $e) {
        $responseError =  '{ "error": "message": "'.$e->getMessage().'"}';
        echo json_encode($responseError);
    }
    
});


$app->put($prefixv2.'/users/activated', function(Request $request, Response $response){


    $id = $request->getParam('id');

    /*
    {
    "id":""
    }
    */
    
    $query = "UPDATE `users` SET `isActive` = 'true' WHERE `users`.`id` = :id";

    try {
        
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'user is activated');
        echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
    
});


$app->post($prefixv2.'/users/add/school', function(Request $request, Response $response){

    $name = $request->getParam('name');
    $last = $request->getParam('lastname');
    $email = $request->getParam('email');

    /*
        body 

    {
        "name":""
        "lastname":""
        "email":""
        "password":""
        "role":""
    }
    */

    $hash = new Hash();
    $passHash = $hash->encryptHash($pass);
    $hash = null;
    
    $query = "INSERT INTO 
        `users` 
        (
            `id`, 
            `firstName`, 
            `lastName`, 
            `email`, 
            `pass`, 
            `rol`) VALUES 
            (
            NULL, 
            :name, 
            :lastname, 
            :email, 
            :pass, 
            :role)";

    try {
        
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':lastname', $last);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pass', $passHash);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'registered user');
        echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
    
});


