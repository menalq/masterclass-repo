<?php

$di = new \Aura\Di\Container(new \Aura\Di\Factory());

$di->params['MOOP\MasterController'] = array(
	'container'	=> $di,
	'config'	=> $config,
	'router'	=> $di->lazyNew('MOOP\Router\Router')
);

$di->params['MOOP\Router\Router'] = array(
	'serverVars'	=> $_SERVER,
	'config'    	=> $di->lazyNew('MOOP\Router\RouterConfig')
);

$di->params['MOOP\Router\RouterConfig'] = [
    'config' => $config['routes']
];

$di->params['MOOP\Controller\Comment'] = array(
	'model' => $di->lazyNew('MOOP\Model\Comment')
);

$di->params['MOOP\Controller\Index'] = array(
	'model' => $di->lazyNew('MOOP\Model\Story')
);

$di->params['MOOP\Controller\Story'] = array(
	'model' => $di->lazyNew('MOOP\Model\Story')
);

$di->params['MOOP\Controller\User'] = array(
	'model' => $di->lazyNew('MOOP\Model\User')
);

$di->params['MOOP\Model\Comment'] = array(
	'db' => $di->lazyNew('MOOP\Dbal\MysqlDb')
);

$di->params['MOOP\Model\Story'] = array(
	'db' => $di->lazyNew('MOOP\Dbal\MysqlDb')
);

$di->params['MOOP\Model\User'] = array(
	'db' => $di->lazyNew('MOOP\Dbal\MysqlDb')
);

$di->params['MOOP\Dbal\MysqlDb'] = array(
	'dsn'	=> 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['name'],
	'user'	=> $config['database']['user'],
	'pass'	=> $config['database']['pass']
);