<?php

namespace MOOP;

use Aura\Di\Container;
use MOOP\Router\Router;

class MasterController {
    
    private $config;
	private $container;
	private $router;
    
    public function __construct(Container $container, $config, Router $router) {
		$this->container = $container;
        $this->_setupConfig($config);
		$this->router = $router;
    }
    
    public function execute() {
        try {
            $call = $this->_determineControllers();
        } catch (\Exception $e) {
            $o = $this->container->newInstance('MOOP\Controller\Error');
            return $o->showError($e->getMessage());
        }
        $o = $this->container->newInstance($call->getRouteClass());
        return $o->{$call->getRouteMethod()}();
    }
    
    private function _determineControllers() {
        $rule = $this->router->validateRequest();
        if (!$rule) {
            throw new \Exception('No route match found!');
         }
        return $rule;
    }
    
    private function _setupConfig($config) {
        $this->config = $config;
    }
    
}