<?php
include __DIR__ . "/vendor/autoload.php";

$sentence = '';
foreach ($_SERVER as $index => $data) {
    $sentence .= "$index --> $data" . PHP_EOL;
}
echo nl2br($sentence);
