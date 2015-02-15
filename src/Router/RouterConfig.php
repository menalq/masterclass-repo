<?php
namespace MOOP\Router;

use MOOP\Router\Route\GetRoute;
use MOOP\Router\Route\PostRoute;

class RouterConfig
{
    private $routes;
    
    public function __construct(array $config)
    {
        foreach($config as $path => $route) {
            if ($route['type'] == 'POST') {
                $this->routes[] = new PostRoute($path, $route['class'], $route['method']);
            } else {
                $this->routes[] = new GetRoute($path, $route['class'], $route['method']);
            }
        }
    }
    
    public function getRoutes()
    {
        return $this->routes;
    }
}