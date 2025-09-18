<?php

namespace Core;

class Request{

    public function method(): string {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }

    public function isPost(): bool {
        return $this->method() === "POST";
    }

    public function isGet(): bool {
        return $this->method() === "GET";
    }

    public function post(string $key, $default = null): mixed {
        return $_POST[$key] ?? $default;
    }

    public function get(string $key, $default = null): mixed {
        return $_GET[$key] ?? $default;
    }

    public function all(): array {
        return array_merge($_GET, $_POST);
    }

    public function filter(array $data): array {
        return filter_var_array($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
}