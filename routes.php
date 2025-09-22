<?php

use App\Models\MonModel;
use App\Controllers\MonController;
use Core\Router;

$model = new MonModel();
$controller = new MonController($model);
$router = new Router();

$router->get('/', [MonController::class, 'showHomePage']); //GET
$router->get('/about', [MonController::class, 'shouwAboutPage']);
$router->get('/inscription', [MonController::class, 'showInscriptionPage']); //GET
$router->post('/sinscrire', [MonController::class, 'handleInscription']); //GET
$router->get('/upload', [MonController::class, 'showUploadPage']); //GET
$router->post('/upload/chunk', [MonController::class, 'handleChunkUpload']); //GET

$router->dispatch();