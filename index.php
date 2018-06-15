<?php
include __DIR__ . "/vendor/autoload.php";
//---------------------------------------------------------

if (!isset($_SERVER['PATH_INFO'])) {
    exit;
}
$pathInfo = trim($_SERVER['PATH_INFO'], '/');
$pathInfoData = explode('/', $pathInfo);

$method = $_SERVER['REQUEST_METHOD'];

$className  = strtoupper(substr($pathInfoData[0], 0, 1)) . substr($pathInfoData[0], 1) . 'Controller';
$contentType = explode(';', $_SERVER['CONTENT_TYPE'])[0];
$authorization = $_SERVER['HTTP_AUTHORIZATION'];
if (file_exists('./src/controllers/' . $className . '.php')) {
    $class = 'GalleryAPI\\controllers\\' . $className ;
    $provider = new $class($pathInfoData, $method, $contentType, $authorization);
}
