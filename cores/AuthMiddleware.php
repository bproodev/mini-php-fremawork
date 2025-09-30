<?php
namespace Core;

class AuthMiddleware
{
    public static function handle(): void
    {

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
            // Rediriger vers la page de login
            redirect("/admin/login");
            exit;
        }
    }
}

