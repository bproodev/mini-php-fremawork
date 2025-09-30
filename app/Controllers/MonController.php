<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;
use Core\UploadController;
use Core\EmailService;

class MonController{

    private $userModel;
    private $request;
    private $uploader;
    private $logger;
    private $emailService;

    public function __construct($model) {
        $this->userModel = $model;
        $this->request = new Request();
        $this->uploader = new UploadController();
        $this->emailService = new EmailService();
        $this->logger = $GLOBALS['logger'];
    }

    public function showHomePage() {
        $produit_vedettes = $this->userModel->getFeaturedProducts();
        $produit_luxes = $this->userModel->getLuxuryProducts();

        view("home", ['produit_vedettes' => $produit_vedettes, 'produit_luxes' => $produit_luxes]);
    }
    
    public function showAboutPage() {
        view("about");
    }
    public function showContactPage() {
        view("contact");
    }
    public function showServicesPage() {
        view("services");
    }
    public function showProduitPage($slug) {
        $produit = $this->userModel->findBySlug($slug);
        view("produit", ['produit' => $produit]);
    }

    public function showProduitsPage() {
        $produits = $this->userModel->getAllActive();
        view("produits", ['produits' => $produits]);
    }

    public function showInscriptionPage() {
        view("inscription", ['user'=> $user ?? null]);
    }

    public function handleInscription() {
        if ($this->request->isPost()) {

            $data = $this->request->filter($this->request->all());

            $validator = new Validator(
                $data,
                [
                    "nom" => "required|min:2|max:20",
                    "prenom" => "required|min:3|max:15",
                    "email" => "required|email",
                    "password" => "required|min:6"
                ]
            );

            if($validator->fails()){
                view("inscription", [
                    "errors" => $validator->errors(),
                    "old" => $data
                ]);
            }

            $filename = $this->uploader->upload([
                "avatar" => "file|mimes:jpg,jpeg,png,gif|max:2048"
            ], "avatar");
            
            if($filename){
                $data['avatar'] = $filename;
            }
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $id = $this->userModel->create($data);
            $user = $this->userModel->find($id);
            $this->emailService->enqueueEmail(
                $user['email'],
                "Bienvenue ".$user['prenom'],
                "<h1>Merci pour votre inscription, ".$user['prenom']."</h1><p>Nous sommes ravis de vous compter parmi nous.</p>"
            );
            view("inscription", ["user" => $user]);
        } else {
            echo "Méthode non autorisée.";
        }
    }

    public function showUploadPage() {
        view("upload", ["fileName" => $fileName ?? null]);
    }

    public function handleChunkUpload() {
        try {
            if($this->request->isPost()){
                $data = $this->request->filter($this->request->all());
                $validator = new Validator(
                    $data,
                    [
                        "avatar" => "file",
                        "identifier" => "required",
                        "chunkIndex" => "required",
                        "totalChunks" => "required"
                    ]
                );

                if($validator->fails()){
                    http_response_code(400);
                    $msg = "errors: ".json_encode($validator->errors());
                    $this->logger->log($msg, "ERROR");
                    echo json_encode(["errors" => $validator->errors()]);
                    exit;
                }

                $fileName = $this->uploader->uploadChunk(
                    "avatar",
                    $data['identifier'],
                    (int)$data['chunkIndex'],
                    (int)$data['totalChunks'],
                    $data['originalName'] ?? null
                );
                // Check if the current chunk is the final chunk
                if ((int)$data['chunkIndex'] === (int)$data['totalChunks']) {
                    // If it is the final chunk, echo the file name
                    if($fileName){
                        echo json_encode(["fileName" => $fileName]);
                    } else {
                        http_response_code(500);
                        $this->logger->log("Error: \"Erreur lors du téléchargement du chunk.", "ERROR");
                        echo json_encode(["error" => "Erreur lors du téléchargement du chunk."]);
                    }
                }

                http_response_code(200);
                echo json_encode(["status" => "Chunk uploaded successfully"]);
            } else {
                echo "Méthode non autorisée.";
            }
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}   