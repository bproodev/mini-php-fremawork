<?php

use App\Models\MonModel;
use App\Models\AdminModel;
use App\Models\AuthModel;
use App\Controllers\MonController;
use App\Controllers\AdminController;
use App\Controllers\AuthController;
use Core\Router;
use Core\AuthMiddleware;

$model = new MonModel();
$adminModel = new AdminModel();
$authModel = new AuthModel();
$controller = new MonController($model);
$controllerAdmin = new AdminController($adminModel);
$controllerAuth = new AuthController($authModel);
$router = new Router();

$router->get('/', [MonController::class, 'showHomePage']); //GET
$router->get('/about', [MonController::class, 'showAboutPage']);
$router->get('/contact', [MonController::class, 'showContactPage']);
$router->get('/services', [MonController::class, 'showServicesPage']);
$router->get('/produits', [MonController::class, 'showProduitsPage']);
$router->get('/produits/{slug}', [MonController::class, 'showProduitPage']);

// Admin Routes

// Authentication
$router->get('/admin/login', [AuthController::class, 'showLoginPage']); //GET
$router->post('/admin/login', [AuthController::class, 'handleLogin']); //POST
$router->get('/admin/register', [AuthController::class, 'showRegisterPage']); //GET
$router->post('/admin/register', [AuthController::class, 'handleRegister']); //POST
$router->get('/admin/logout', [AuthController::class, 'handleLogout']); //GET
$router->get('/admin/verify-code', [AuthController::class, 'showVerifyCodePage']); //GET
$router->post('/admin/verify-code', [AuthController::class, 'handleVerifyCode']); //POST

// Protected Admin Routes
$router->get('/admin/dashboard', [AdminController::class, 'showDashboardPage'], [AuthMiddleware::class]); //GET
$router->get('/admin/products', [AdminController::class, 'showProductsPage'], [AuthMiddleware::class]); //GET
$router->get('/admin/products/create', [AdminController::class, 'showCreateProductPage'], [AuthMiddleware::class]); //GET
$router->post('/admin/products', [AdminController::class, 'handleCreateProduct'], [AuthMiddleware::class]); //POST
$router->get('/admin/products/{id}/edit', [AdminController::class, 'showEditProductPage'], [AuthMiddleware::class]); //GET
$router->put('/admin/products/{id}', [AdminController::class, 'handleEditProduct'], [AuthMiddleware::class]); //PUT
$router->delete('/admin/products/{id}', [AdminController::class, 'handleDeleteProduct'], [AuthMiddleware::class]); //DELETE

// $router->get('/inscription', [MonController::class, 'showInscriptionPage']); //GET
// $router->post('/sinscrire', [MonController::class, 'handleInscription']); //GET
// $router->get('/upload', [MonController::class, 'showUploadPage']); //GET
// $router->post('/upload/chunk', [MonController::class, 'handleChunkUpload']); //GET

$router->get('/process-email-queue', function() {
    include __DIR__ . '/process_email_queue.php';
}); //GET

$router->dispatch();