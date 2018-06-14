<?php
include __DIR__ . "/vendor/autoload.php";

echo substr(hash('md5',uniqid()), 0, rand(5, 11));