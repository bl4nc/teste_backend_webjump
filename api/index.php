<?php
require_once "vendor/autoload.php";
ini_set('memory_limit', '-1');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");

use App\Routes\Router;

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router = new Router($uri,$method);
$router->run();