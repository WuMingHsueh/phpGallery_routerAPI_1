<?php
include __DIR__ . "/vendor/autoload.php";

$length = 10;

$array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
shuffle($array);
echo implode('', array_slice($array, 0, $length));
