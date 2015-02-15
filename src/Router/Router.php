<?php
namespace MOOP\Router;

use MOOP\Router\Route\RouteInterface;
use MOOP\Router\RouterConfig;

class Router
{
	private $serverVars;
	private $routes;
	
	public function __construct(array $serverVars, RouterConfig $config)
	{
		$this->serverVars = $serverVars;
		foreach ($config->getRoutes() as $route) {
			$this->addRoute($route);
		}
	}
	
	private function addRoute(RouteInterface $route)
	{
		$this->routes[] = $route;
	}
	
	public function validateRequest() {
		$path = parse_url($this->serverVars['REQUEST_URI'], PHP_URL_PATH);
		
		foreach($this->routes as $route) {
            if ($route->matchRoute($path, $this->serverVars['REQUEST_METHOD'])) {
                return $route;
            }
        }
        return false;
	}
}
