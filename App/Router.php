<?php

namespace App;

use App\Exceptions\ControllerNotFoundException;
use App\Exceptions\RouteActionException;
use App\Exceptions\RouteNotFoundException;

class Router
{
    protected array $routes = [];
    protected string $requestMethod;
    protected string $path;
    protected ?string $queryString;

    public function __construct()
    {
        $this->requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $this->path = explode('?', $_SERVER['REQUEST_URI'])[0];
        $this->queryString = $_SERVER['QUERY_STRING'] ?? null;
    }

    public function register(string $requestMethod, string $uri, callable|array $action)
    {
        $this->routes[$requestMethod][$uri] = $action;
    }

    public function routes()
    {
        return $this->routes;
    }

    public function get(string $uri, callable|array $action)
    {
        $this->register('get', $uri, $action);
    }

    public function post(string $uri, callable|array $action)
    {
        $this->register('post', $uri, $action);
    }

    protected function getMatchingRoute()
    {
        return $this->routes[$this->requestMethod][$this->path] ?? null;
    }

    public function resolve()
    {
        $action = $this->getMatchingRoute() ?? throw new RouteNotFoundException('404 Page Not Found');

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $controller = new $class();

            if (method_exists($controller, $method)) {
                return call_user_func_array([$controller, $method], []);
            }

            throw new RouteActionException("{$class}::{$method}");
        }

        throw new ControllerNotFoundException($class);
    }
}
