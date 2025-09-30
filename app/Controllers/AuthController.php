<?php

namespace App\Controllers;

use Core\Request;
use Core\Validator;
use Core\UploadController;
use Core\EmailService;

class AuthController {

    private $authModel;
    private $request;
    private $uploader;
    private $logger;
    private $emailService;

    public function __construct($model) {
        $this->authModel = $model;
        $this->request = new Request();
        $this->uploader = new UploadController();
        $this->emailService = new EmailService();
        $this->logger = $GLOBALS['logger'];
    }

    public function showLoginPage() {
        view("auth.login", ['user'=> $user ?? null]);
    }

    public function handleLogin() {
        if ($this->request->isPost()) {

            $data = $this->request->filter($this->request->all());

            $validator = new Validator(
                $data,
                [
                    "email" => "required|email",
                    "password" => "required|min:6|max:20",
                ]
            );

            if($validator->fails()){
                view("auth.login", [
                    "errors" => $validator->errors(),
                    "old" => $data
                ]);
            }

            // Check if user exists
            $user = $this->authModel->findByEmail($data['email']);
            if (!$user || !password_verify($data['password'], $user['password'])) {
                view("auth.login", [
                    "errors" => ["Invalid email or password."],
                    "old" => $data
                ]);
            }

            // Set session and redirect to dashboard
            session_set('user_id', $user['id']);
            session_set('username', $user['username']);
            
            $this->logger->log("User logged in with ID: " . $user['id'] . " and email: " . $user['email']);
            redirect("/admin/dashboard");
            exit();
        }
    }
    
    public function showRegisterPage() {
        view("auth.register", ['user'=> $user ?? null]);
    }

    public function handleRegister() {
        if ($this->request->isPost()) {

            $data = $this->request->filter($this->request->all());



            $validator = new Validator(
                $data,
                [
                    "username" => "required|min:2|max:20",
                    "email" => "required|email",
                    "password" => "required|min:6|max:20",
                ]
            );

            if($validator->fails()){
                view("auth.register", [
                    "errors" => $validator->errors(),
                    "old" => $data
                ]);
            }

            // Check if email already exists
            if ($this->authModel->findByEmail($data['email'])) {
                view("auth.register", [
                    "errors" => ["Email already in use."],
                    "old" => $data
                ]);
            }

            // Generate verification code
            $verifyCode = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
            $data['verify_code'] = $verifyCode;
            // Hash password and create user
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
            $userId = $this->authModel->create($data);


            $this->logger->log("New user registered with ID: $userId and email: " . $data['email']);
            //Engueue the welcome email (optional)
            $this->emailService->enqueueEmail(
                $data['email'],
                "Salut a toi " . htmlspecialchars($data['username']) . "!",
                "Merci d'avoir créé un compte, veillerez votre email avec ce code: {$verifyCode} Merci!"
            );

            $email = $data['email'];
            // Redirect to login page
            view("auth.verify_code", ['email'=> $email]);
            // exit();
        }
    }

    public function showVerifyCodePage() {
        view("auth.verify_code", ['email'=> $email ?? null]);
    }

    public function handleVerifyCode() {
        if ($this->request->isPost()) {
            $data = $this->request->filter($this->request->all());

            $validator = new Validator(
                $data,
                [
                    "email" => "required|email",
                    "verify_code" => "required|min:6|max:6",
                ]
            );

            if($validator->fails()){
                view("auth.verify_code", [
                    "errors" => $validator->errors(),
                    "old" => $data
                ]);
            }

            // Check if user exists and code matches
            $user = $this->authModel->findByEmail($data['email']);
            if (!$user || $user['verify_code'] !== $data['verify_code']) {
                view("auth.verify_code", [
                    "errors" => ["Invalid email or verification code."],
                    "old" => $data
                ]);
            }

            // Update user as verified
            $this->authModel->update($user['id'], [
                'verified_at' => date('Y-m-d H:i:s'),
                'verify_code' => null
            ]);

            // Redirect to login page with success message
            redirect("/admin/login?verified=1");
            exit();
        }
    }

    public function handleLogout() {
        // Clear all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // (Optional) remove the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        redirect("/admin/login");
        exit();
    }

}