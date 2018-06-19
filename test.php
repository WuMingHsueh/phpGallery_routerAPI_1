<?php
include __DIR__ . "/vendor/autoload.php";

use GalleryAPI\service\ImageService as ImageService;

(new ImageService)->test();