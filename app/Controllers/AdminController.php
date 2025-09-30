<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;
use Core\UploadController;
use Core\EmailService;

class AdminController {

    private $adminModel;
    private $request;
    private $uploader;
    private $logger;
    private $emailService;

    public function __construct($model) {
        $this->adminModel = $model;
        $this->request = new Request();
        $this->uploader = new UploadController();
        $this->emailService = new EmailService();
        $this->logger = $GLOBALS['logger'];
    }

    public function showDashboardPage() {
        view("admin.home");
    }

    public function showProductsPage() {
        $products = $this->adminModel->all();
        view("admin.products", ['products' => $products]);
    }

    public function showCreateProductPage() {
        view("admin.create");
    }

    public function handleCreateProduct() {
        if ($this->request->isPost()) {
            $data = $this->request->filter($this->request->all());

            $validator = new Validator(
                $data,
                [
                    "product_name" => "required|min:5|max:100",
                    "product_description" => "required|min:10|max:150",
                    "product_price" => "required",
                    "product_category" => "required",
                ]
            );

            if($validator->fails()){
                view("admin.create", [
                    "errors" => $validator->errors(),
                    "old" => $data
                ]);
            }

            $filename = $this->uploader->upload([
                "product_image" => "file|mimes:jpg,jpeg,png|max:2048",
            ], "product_image");
            
            if($filename){
                $data['product_image'] = $filename;
            }
            $data['slug'] = slugify($data['product_name']);
            $id = $this->adminModel->create($data);
            $produit = $this->adminModel->find($id);
            $this->emailService->enqueueEmail(
                'hello@bproodev.com',
                "Produit créé avec succès",
                "<h1>Votre produit {$produit['product_name']} a été créé avec succès</h1>"
            );
            redirect("/admin/products");

        } else {
            echo "Méthode non autorisée.";
        }
    }

    public function showEditProductPage($id) {
        $product = $this->adminModel->find($id);
        if (!$product) {
            echo "Produit non trouvé.";
            return;
        }
        view("admin.edit", ['product' => $product]);
    }
    public function handleEditProduct($id) {
        if ($this->request->isPost()) {
            $data = $this->request->filter($this->request->all());

            $validator = new Validator(
                $data,
                [
                    "product_name" => "required|min:5|max:100",
                    "product_description" => "required|min:10|max:150",
                    "product_price" => "required",
                    "category" => "required",
                    "status" => "required"
                ]
            );

            if($validator->fails()){
                $this->logger->log('Validation errors: ' . json_encode($validator->errors()), 'ERROR');
                $product = $this->adminModel->find($id);
                view("admin.edit", [
                    "errors" => $validator->errors(),
                    "old" => $data,
                    'product' => $product
                ]);
                return;
            }

            // Vérifier si une nouvelle image a été envoyée
            if (!empty($_FILES['product_image']['name'])) {
                $filename = $this->uploader->upload([
                    "product_image" => "file|mimes:jpg,jpeg,png|max:2048",
                ], "product_image");
                
                if ($filename) {
                    $data['product_image'] = $filename;
                }
            } else {
                // Si aucune nouvelle image n'est envoyée, on récupère l'ancienne image
                $oldProduct = $this->adminModel->find($id);
                $data['product_image'] = $oldProduct['product_image'];
            }

            $data['slug'] = slugify($data['product_name']);
            $this->adminModel->update($id, $data);
            redirect("/admin/products");

        } else {
            echo "Méthode non autorisée.";
        }
    }

    public function handleDeleteProduct($id) {
        if ($this->request->isPost()) {
            $product = $this->adminModel->find($id);
            if (!$product) {
                echo "Produit non trouvé.";
                return;
            }
            $this->adminModel->delete($id);
            $imagePath = __DIR__ . '/../../public/uploads/' . $product['product_image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprimer l'image du serveur
            }

            redirect("/admin/products");
        } else {
            echo "Méthode non autorisée.";
        }
    }

    public function showLoginPage() {
        view("admin.login");
    }

    public function handleLogin() {
        // Handle login logic here
    }

    public function showRegisterPage() {
        view("admin.register");
    }

    public function handleRegister() {
        // Handle registration logic here
    }

    public function handleLogout() {
        // Handle logout logic here
    }
}