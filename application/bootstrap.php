<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

define('ROOT_PATH', dirname(__FILE__) );

try {
    require_once __DIR__ . '/../vendor/autoload.php';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

