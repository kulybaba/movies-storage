<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include(ROOT . '/config/routes.php');
    }

    public function run()
    {
        $uri = trim($_SERVER['REQUEST_URI'], '/');

        foreach ($this->routes as $uriPattern => $path) {

            if (preg_match("~{$uriPattern}~", $uri)) {
                $route = preg_replace("~{$uriPattern}~", $path, $uri);
                $segments = explode('/', $route);

                $controllerName = ucfirst(array_shift($segments) . 'Controller');
                $actionName = array_shift($segments) . 'Action';
                $params = $segments;

                $controllerPath = ROOT . "/src/Controllers/{$controllerName}.php";
                if (!file_exists($controllerPath)) {
                    throw new Exception("Not found controller: {$controllerPath}");
                }

                $controller = new $controllerName;
                if (!method_exists($controller, $actionName)) {
                    throw new Exception("Not fount action: {$actionName} of controller {$controllerPath}");
                }

                $controller->$actionName($params);
            }
        }
    }

}
