<?php

define('BASE_PATH', realpath(__DIR__ . '/../../'));
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(BASE_PATH);
$dotenv->load();
   
?>
