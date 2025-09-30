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

if (!function_exists('redirect')) {
    function redirect(string $url): void
    {
        if (ob_get_length()) {
            ob_end_clean(); // clear buffer
        }
        header("Location: " . BASE_PATH . $url);
        exit;
    }
}


if (!function_exists('asset')) {
    function asset(string $path): string {
        // On suppose que ton dossier public est /public
        $baseUrl = $_ENV['APP_URL'] ?? BASE_PATH;
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('slugify')) {
    function slugify(string $string): string
    {
        // Replace non-alphanumeric characters (except spaces and hyphens) with a hyphen
        $slug = preg_replace('/[^a-zA-Z0-9\s-]/', '', $string);

        // Replace one or more spaces with a single hyphen
        $slug = preg_replace('/[\s]+/', '-', $slug);

        // Convert the string to lowercase
        $slug = strtolower($slug);

        // Remove any leading or trailing hyphens
        $slug = trim($slug, '-');

        return $slug;
    }

    if (!function_exists('session_get')) {
        function session_get(string $key, $default = null) {
            return $_SESSION[$key] ?? $default;
        }
    }

    if (!function_exists('session_set')) {
        function session_set(string $key, $value): void {
            $_SESSION[$key] = $value;
        }
    }

    if (!function_exists('session_remove')) {
        function session_remove(string $key): void {
            unset($_SESSION[$key]);
        }
    }
}


