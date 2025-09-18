<?php

namespace Core;

class Router{

    private array $routes = [];

    public function get(string $path, callable|array $action) {
        $this->addRoute('GET', $path, $action);
    }

    public function post(string $path, callable|array $action) {
        $this->addRoute('POST', $path, $action);
    }

    public function put(string $path, callable|array $action) {
        $this->addRoute('PUT', $path, $action);
    }

    public function patch(string $path, callable|array $action) {
        $this->addRoute('PATCH', $path, $action);
    }

    public function delete(string $path, callable|array $action) {
        $this->addRoute('DELETE', $path, $action);
    }

    private function addRoute(string $method, string $path, callable|array $action) {

        $pattern = preg_replace('/\{(\w+)\}/', '([\w-]+)', $path);
        $pattern = "#^" . trim($pattern, '/') . "$#";

        $this->routes[$method][] = [
            'pattern' => $pattern,
            'action' => $action
        ];
    }


    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim(str_replace(BASE_PATH, '', $uri), '/');

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "Route not found.";
            return;
        }

        foreach ($this->routes[$method] as $route) {

            if (preg_match($route['pattern'], $uri, $matches)) {
                array_shift($matches); // Remove the full match

                if (is_array($route['action'])) {
                    [$controllerClass, $methodName] = $route['action'];
                    if (class_exists($controllerClass) && method_exists($controllerClass, $methodName)) {
                        $reflection = new \ReflectionClass($controllerClass);
                        $constroctor = $reflection->getConstructor();
                        $params = $constroctor ? $constroctor->getParameters() : [];
                        if(count($params) === 0){
                            $controller = new $controllerClass();
                        } else {
                            $modelName = str_replace('Controller', 'Model', $controllerClass);
                            if(class_exists($modelName)){
                                $model = new $modelName();
                                $controller = new $controllerClass($model);
                            } else {
                                throw new Exception("Model class $modelName does not exist.");
                            }
                        }

                        call_user_func_array([$controller, $methodName], $matches);
                        return;
                    }
                } elseif (is_callable($route['action'])) {
                    call_user_func_array($route['action'], $matches);
                    return;
                }
            }
        }

        http_response_code(404);
        echo "Route not found.";
    }

}