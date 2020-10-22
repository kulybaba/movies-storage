<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

define('ROOT', __DIR__);
require_once(ROOT . '/vendor/autoload.php');
require_once(ROOT . '/config/components/autoload.php');

$router = new Router();
$router->run();
