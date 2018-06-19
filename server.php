<?php

$msg = '';
foreach ($_SERVER as $key => $value) {
    $msg .= "$key --------> $value" . PHP_EOL;
}

echo nl2br($msg);