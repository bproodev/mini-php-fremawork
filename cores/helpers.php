<?php

use Core\View;

if (!function_exists('view')) {
    function view(string $view, array $data = []): void
    {
        try {
            echo View::render($view, $data);
        } catch (\Exception $e) {
            echo "La vue [$view] est introuvable: " . $e->getMessage();
        }
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        // On suppose que ton dossier public est /public
        $baseUrl = $_ENV['APP_URL'] ?? BASE_PATH;
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}