<?php
include __DIR__ . "/vendor/autoload.php";

$sentence = '';
foreach ($_SERVER as $index => $data) {
    $sentence .= "$index --> $data" . PHP_EOL;
}
echo nl2br($sentence);

echo "<hr>";

echo explode(';', $_SERVER['CONTENT_TYPE'])[0];
echo "!!!";