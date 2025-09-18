<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;

class MonController{

    private $userModel;
    private $request;

    public function __construct($model) {
        $this->userModel = $model;
        $this->request = new Request();
    }

    public function showHomePage() {
        $users = $this->userModel->all();
        view("home", ["users" => $users]);
    }

    public function showInscriptionPage() {
        view("inscription");
    }

    public function handleInscription() {
        if ($this->request->isPost()) {

            $data = $this->request->filter($this->request->all());

            $validator = new Validator(
                $data,
                [
                    "nom" => "required|min:2|max:20",
                    "prenom" => "required|min:3|max:15"
                ]
            );

            if($validator->fails()){
                view("inscription", [
                    "errors" => $validator->errors(),
                    "old" => $data
                ]);
            }

            $nom = $data['nom'] ?? '';
            $prenom = $data['prenom'] ?? '';
            
           // $message = $this->model->inscrire($nom, $prenom);
            view("inscription", ["message" => $message]);
        } else {
            echo "Méthode non autorisée.";
        }
    }

}   