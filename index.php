<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath('/testservice');

require __DIR__ . '/dbconnect.php';
require __DIR__ . '/api/user.php';
require __DIR__ . '/api/type.php';
require __DIR__ . '/api/image.php';
require __DIR__ . '/api/comment.php';
require __DIR__ . '/api/activity.php';

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->run();