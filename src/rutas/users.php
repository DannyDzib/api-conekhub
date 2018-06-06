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


$app->get($prefixv2.'/users/following/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $query = "SELECT U.follower_id, F.firstName
    FROM following U
    LEFT JOIN users F ON F.id = U.follower_id WHERE U.user_id = '$id'";

    try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $followers = array(
            'following' => $result
        );

        echo json_encode($followers);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "'.$e->getMessage().'"}';
    }
    
});

$app->get($prefixv2.'/users/followers/{id}', function(Request $request, Response $response) {

    $id = $request->getAttribute('id');

    $query = "SELECT U.user_id, F.firstName 
    FROM following U 
    INNER JOIN users F 
    ON F.id = U.user_id 
    WHERE U.follower_id = '$id'";




    try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;

        $followers = array(
            'followers' => $result
        );

        echo json_encode($followers);

    } catch(PDOException $e) {
        echo '
            { "error": "message": "'.$e->getMessage().'"}';
    }
    
});

$app->post($prefixv2.'/users/followed', function(Request $request, Response $response){

    $id_user = $request->getParam('id_user');
    $follower_id = $request->getParam('id_follow');


    $query = "INSERT INTO `following` (`user_id`, `follower_id`) VALUES (:user_id, :follower_id)";

    try {

        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $id_user);
        $stmt->bindParam(':follower_id', $follower_id);
        $stmt->execute();
    
      $res = array(
          'message' => 'Succes follow'
      );

      echo json_encode($res);

  } catch(PDOException $e) {
      $responseError =  '{ "error": "message": "'.$e->getMessage().'"}';
      echo json_encode($responseError);
  }
  
});


$app->delete($prefixv2.'/users/unfollow', function(Request $request, Response $response){

    $id_user = $request->getParam('id_user');
    $follower_id = $request->getParam('id_follow');


    $query = "DELETE FROM `following` WHERE `following`.`user_id` = :user_id AND `following`.`follower_id` = :follower_id";

    try {

        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $id_user);
        $stmt->bindParam(':follower_id', $follower_id);
        $stmt->execute();
    
      $res = array(
          'message' => 'Succes unfollow'
      );

      echo json_encode($res);

  } catch(PDOException $e) {
      $responseError =  '{ "error": "message": "'.$e->getMessage().'"}';
      echo json_encode($responseError);
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


$app->post($prefixv2.'/users/url/exists', function(Request $request, Response $response){

    $url = $request->getParam('url');
    
    $query = "SELECT U.url_profile FROM estudent U WHERE url_profile='$url'";

    try {
        
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetch(PDO::FETCH_ASSOC);

        $existe = Array('exists' => false);
        if($result['url_profile']) {
            $existe = Array('exists' => true);
        } 
        $db = null; 
        echo json_encode($existe);


    } catch(PDOException $e) {
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
    
});


$app->post($prefixv2.'/users/email/exists', function(Request $request, Response $response){

    $email = $request->getParam('email');
    
    $query = "SELECT U.email FROM users U WHERE email='$email'";

    try {
        
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetch(PDO::FETCH_ASSOC);

        $existe = Array('exists' => false);
        if($result['email']) {
            $existe = Array('exists' => true);
        } 
        $db = null; 
        echo json_encode($existe);


    } catch(PDOException $e) {
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
    
});

$app->post($prefixv2.'/users/add/school', function(Request $request, Response $response){

    $idUser = $request->getParam('id_user');
    $idSchool = $request->getParam('id_school');
    $idCareer = $request->getParam('id_career');
    $url = $request->getParam('url');

    /*
        body 

    {
        "id_user":""
        "id_school":""
        "id_career":""
    }
    */
    
    $query = "INSERT INTO `estudent` 
    (`id`, 
    `id_school`, 
    `id_career`, 
    `url_profile`) 
    VALUES (
        :idUser, 
        :idSchool, 
        :idCareer, 
        :url)";

    try {
        
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':idSchool', $idSchool);
        $stmt->bindParam(':idCareer', $idCareer);
        $stmt->bindParam(':url', $url);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'registered student data');
        echo json_encode($json);

    } catch(PDOException $e) {
        $json_error = Array('status' => 'Failed', 'message' => 'No se pudo registrar al usuario', 'type_error' => $e->getMessage());
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
    
});


$app->post($prefixv2.'/users/add/post',  function(Request $request, Response $response){

    $PostTitle = $request->getParam('title');
    $PostContent = $request->getParam('content');
    $OwnerID = $request->getParam('owner_id');

    /* 
    {"title":"Busco trabajo de velero de barco", 
    "content":"soy un navegante", 
    "owner_id":"1"}

     */

    $query = "INSERT INTO 
    `post` 
    (
        `PostId`, 
        `PostTitle`, 
        `PostContent`,
        `OwnerID`
    ) VALUES 
    (
        NULL, 
        :PostTitle, 
        :PostContent,
        :OwnerID)";

    try {
            
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':PostTitle', $PostTitle);
        $stmt->bindParam(':PostContent', $PostContent);
        $stmt->bindParam(':OwnerID', $OwnerID);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'registered post data for student');
        echo json_encode($json);

    } catch(PDOException $e) {
        echo '{"error": {"text": "'.$e->getMessage().'"}';
    }
});

$app->post($prefixv2.'/users/add/experience',  function(Request $request, Response $response){

    $employment = $request->getParam('employment');
    $ingress = $request->getParam('ingress');
    $egress = $request->getParam('egress');
    $actual = $request->getParam('actual');
    $id_user = $request->getParam('id_user');

    /* 
    {"employment":"Frontend Developer", 
    "ingress":"2017-01-10", 
    "egress":"2018-01-10", 
    "actual":"1", 
    "id_user":"1"}

     */

    $query = "INSERT INTO 
    `experiences` 
    (`id_experience`, 
    `employment`, 
    `ingress`, 
    `egress`, 
    `actual`, 
    `id_user`) 
    VALUES 
    (NULL, 
    :employment, 
    :ingress, 
    :egress, 
    :actual, 
    :id_user)";

    try {
            
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':employment', $employment);
        $stmt->bindParam(':ingress', $ingress);
        $stmt->bindParam(':egress', $egress);
        $stmt->bindParam(':actual', $actual);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->execute();

        $json = Array('status' => 'Succes', 'message' => 'registered experiencie data for student');
        echo json_encode($json);

    } catch(PDOException $e) {
        echo '{"error": {"text": "'.$e->getMessage().'"}';
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





