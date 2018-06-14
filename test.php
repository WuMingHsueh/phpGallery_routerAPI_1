<?php
include __DIR__ . "/vendor/autoload.php";

// use Spatie\ArrayToXml\ArrayToXml;

// $array = [
//     "data" => [
//         '_attributes' => ["type" => "string" ,"status" => "200", "success" => 1],
//         '_value' => "test"
//     ]
// ];
// $xmlString = ArrayToXml::convert($array);
// echo str_replace("</root>", "", str_replace("<root>", "", $xmlString));
// echo date('U');
echo bin2hex(openssl_random_pseudo_bytes(4));