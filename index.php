<?php
include __DIR__ . "/vendor/autoload.php";
//---------------------------------------------------------

if (!isset($_SERVER['PATH_INFO'])) {
    exit;
}
$pathInfo = trim($_SERVER['PATH_INFO'], '/');
$pathInfoData = explode('/', $pathInfo);

$method = $_SERVER['REQUEST_METHOD'];

$headers = apache_request_headers();

if (file_exists('./src/controllers/'.$pathInfoData[0].'Controller.php')) {
    $class = 'GalleryAPI\\controllers\\'.$pathInfoData[0].'Controller';
    $provider = new $class($pathInfoData, $method, $headers);
}
