<?php

#[Attribute] class Route
{
}
#[Attribute] class Method
{
}

class Router
{
    private $routes = [];
    private $baseControllerPath;

    public function __construct($baseControllerPath)
    {
        $this->baseControllerPath = $baseControllerPath;
    }

    public function autoloadControllers()
    {
        $files = glob($this->baseControllerPath . '/*.php');
        foreach ($files as $file) {
            require_once $file;
            $this->routes[basename($file, '.php')] = [];
        }
    }

    public function getFunctionAttributes()
    {
        foreach ($this->routes as $controller => $route) {
            $reflector = new ReflectionClass($controller);
            $methods = $reflector->getMethods(ReflectionMethod::IS_PUBLIC);
            foreach ($methods as $method) {
                $this->routes[$controller][$method->getName()] = $method->getAttributes();
            }
        }
    }

    public function saveRoutes()
    {
        $json = json_encode($this->routes, JSON_PRETTY_PRINT);
        file_put_contents(getenv('ROUTES_FILE'), $json);
    }

    public function loadRoutes()
    {
        $json = file_get_contents(getenv('ROUTES_FILE'));
        $this->routes = json_decode($json, true);
    }

    public function generateRoutes()
    {
        $this->autoloadControllers();
        $this->getFunctionAttributes();

        $routes = [];
        foreach ($this->routes as $controller => $methods) {
            foreach ($methods as $method => $attributes) {
                $routeAttribute = array_filter($attributes, function ($attribute) {
                    return $attribute->getName() === 'Route';
                });
                $methodAttribute = array_filter($attributes, function ($attribute) {
                    return $attribute->getName() === 'Method';
                });

                if ($routeAttribute) {
                    $route = reset($routeAttribute)->getArguments()[0];
                    $httpMethod = $methodAttribute ? reset($methodAttribute)->getArguments()[0] : 'GET';
                    $routes[$route] = [
                        'http_method' => $httpMethod,
                        'controller' => $controller,
                        'method' => $method,
                    ];
                }
            }
        }
        $this->routes = $routes;
        return $routes;
    }

    public function saveRoutesToFile()
    {
        $json = json_encode($this->routes, JSON_PRETTY_PRINT);
        $json = str_replace("\n", "\r\n", $json);

        $old_content = file_get_contents(getenv('ROUTES_FILE'));
        // var_dump($old_content);
        if ($old_content !== $json) {
            file_put_contents(getenv('ROUTES_FILE'), $json . PHP_EOL);
        }
    }

    public function loadRoutesFromFile()
    {
        $json = file_get_contents(getenv('ROUTES_FILE'));
        $this->routes = json_decode($json, true);
        return $this->routes;
    }
}
