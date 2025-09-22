<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;
use Core\UploadController;

class MonController{

    private $userModel;
    private $request;
    private $uploader;

    public function __construct($model) {
        $this->userModel = $model;
        $this->request = new Request();
        $this->uploader = new UploadController();
    }

    public function showHomePage() {
        $users = $this->userModel->all();

        view("home", ['users' => $users]);
    }
    public function shouwAboutPage() {
        view("about");
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
                    error_log("errors: ".json_encode($validator->errors()));
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
                        error_log("Success: \"Fichier uploader avec success.");
                        echo json_encode(["fileName" => $fileName]);
                    } else {
                        http_response_code(500);
                        error_log("error: \"Erreur lors du téléchargement du chunk.");
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