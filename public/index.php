<?php
define('BASE_PATH', "/mini-php-framework/public");

require_once(__DIR__ . "/../vendor/autoload.php");  

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
\Core\View::init(); // optional: pass custom paths
// \Core\View::display('home', ['name' => 'Bproo Dev']);

require_once(__DIR__ . "/../routes.php");


