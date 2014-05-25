<?php

chdir(__DIR__);

if (!file_exists('../vendor/autoload.php')) {
    throw new \RuntimeException('vendor/autoload.php not found. Run a composer install.');
}

$autoloader = include '../vendor/autoload.php';
$autoloader->add('ImgManLibraryTest', __DIR__);
