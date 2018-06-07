<?php
include __DIR__ . "/vendor/autoload.php";

use GalleryAPI\Routes as Routes;

$pathInfo = trim($_SERVER['PATH_INFO'], '/');
$pathInfoData = explode('/', $pathInfo);
if (empty($pathInfoData)) {
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$request = json_decode(file_get_contents("php://input"), true);

$headers = apache_request_headers();


$router = new Routes($method, $pathInfoData, $headers);
$router->response($request);
