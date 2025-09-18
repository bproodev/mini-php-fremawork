<?php
define('BASE_PATH', "/mini-php-framework/public");

require_once(__DIR__ . "/../vendor/autoload.php");  
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

require_once(__DIR__ . "/../routes.php");


