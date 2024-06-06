<?php
class Router {
    private $getRoutes = [];
    private $postRoutes = [];

    public function get($route, $callback) {
        $this->getRoutes[$route] = $callback;
    }

    public function post($route, $callback) {
        $this->postRoutes[$route] = $callback;
    }

    public function run() {
        $url = isset($_GET['url']) ? $_GET['url'] : '/';
        $url = trim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        $routes = ($method == 'POST') ? $this->postRoutes : $this->getRoutes;

        foreach ($routes as $route => $callback) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
            $pattern = str_replace('/', '\/', $pattern);
            if (preg_match('/^' . $pattern . '$/', $url, $matches)) {
                array_shift($matches);
                if (is_callable($callback)) {
                    call_user_func_array($callback, $matches);
                } else {
                    $this->invokeController($callback, $matches);
                }
                return;
            }
        }

        echo "Route not found: " . htmlspecialchars($url);
    }

    private function invokeController($callback, $params = []) {
        list($controllerName, $action) = explode('@', $callback);
        $controllerFile = __DIR__ . "/../controllers/" . $controllerName . ".php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controller = new $controllerName();
            if (method_exists($controller, $action)) {
                call_user_func_array([$controller, $action], $params);
            } else {
                echo "Action '$action' not found in controller '$controllerName'.";
            }
        } else {
            echo "Controller '$controllerName' not found.";
        }
    }
}
?>
