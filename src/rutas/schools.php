<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$prefixv2 = '/api/v2';


$app->post($prefixv2.'/schools/new', function(Request $request, Response $response){
    
    $school = $request->getParam('name');
    $shortname = $request->getParam('shortname');

    $query = "INSERT INTO `schools` (nameSchool, shortName) VALUES (:nameschool, :shortname)";

    try {
        $db = new db();
        $db = $db->connect();
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nameschool', $school);
        $stmt->bindParam(':shortname', $shortname);
        $stmt->execute();
        //echo $test; 

        $res = array(
            'message' => 'School registered'
        );

        echo json_encode($res);

    } catch(PDOException $e) {
        echo '{ "error": "message": "'.$e->getMessage().'"}';
    }
});


$app->get($prefixv2.'/schools', function(Request $request, Response $response){
    
    $query = 'SELECT nameSchool, shortName FROM schools';

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

$app->get($prefixv2.'/schools/{id}/careers', function(Request $request, Response $response){

    $id = $request->getAttribute('id');
    $query = "SELECT nameCareer FROM careers WHERE school= '$id'";

    try {
        $db = new db();
        $db = $db->connect();
        $ejecutar = $db->query($query);
        $result = $ejecutar->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
        
        

        $simple = array();

        foreach ($result as $value) {
            $simple[] = $value['nameCareer'];
        }

        $escuelas = Array(
            'careers' => $simple
        );

        echo json_encode($escuelas);

    } catch(PDOException $e) {
        echo '{ "error": "message": "'.$e->getMessage().'"}';
    }
});
