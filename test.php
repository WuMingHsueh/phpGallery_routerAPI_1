<?php
include __DIR__ . "/vendor/autoload.php";

use GalleryAPI\Environment;
use GuzzleHttp\Client;

$client = new Client;

$response = $client->request('GET', 'http://192.168.96.140/galleryPHPAPI/image/cover/b48296.jpg');

header("Content-Type: image/jpg");
echo $response->getBody();



