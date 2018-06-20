<?php
include __DIR__ . "/vendor/autoload.php";

use GalleryAPI\service\XmlService;

$helper = new XmlService;

$data = [
    ['id' => 'b186b7042', 'count' => '2'],
    ['id' => '77654bb', 'count' => '8']
];
$xmlString = "";
foreach ($data as $attr) {
    $xmlString .= $helper->xmlEncodeOneLevel('album', $attr);
}


$temp['albums'] = [
    "_cdata" => $xmlString
];
echo $helper->xmlEncodeDataArrayWithCData($temp, ["sucess" => "1", "status" => "200"]);