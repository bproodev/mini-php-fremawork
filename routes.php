<?php

use App\Models\MonModel;
use App\Controllers\MonController;
use Core\Router;

$model = new MonModel();
$controller = new MonController($model);
$router = new Router();

$router->get('/', [MonController::class, 'showHomePage']); //GET
$router->get('/inscription', [MonController::class, 'showInscriptionPage']); //GET
$router->post('/sinscrire', [MonController::class, 'handleInscription']); //GET

$router->dispatch();