<?php

// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE');
// header("Access-Control-Allow-Headers: X-Requested-With");
// header('Content-Type: text/html; charset=utf-8');
// header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 
 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../src/config/db.php';
require '../src/config/hash.php';

$app = new \Slim\App;


$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});


$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
});


// $c = $app->getContainer();
// $c['notAllowedHandler'] = function ($c) {
//     return function ($request, $response, $methods) use ($c) {
//         return $c['response']
//             ->withStatus(405)
//             ->withHeader('Allow', implode(', ', $methods))
//             ->withHeader('Content-type', 'application/json')
//             ->write('Method must be one of: ' . implode(', ', $methods));
//     };
// };


//Crear las rutas de los clientes
//require "../src/rutas/app.php";
require "../src/rutas/escuelas.php";
require "../src/rutas/usuarios.php";

$app->run();