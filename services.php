<?php

$di = new \Aura\Di\Container(new \Aura\Di\Factory());

$di->params['MOOP\MasterController'] = array(
	'container'	=> $di,
	'config'	=> $config
);

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
	'pdo' => $di->lazyNew('PDO')
);

$di->params['MOOP\Model\Story'] = array(
	'pdo' => $di->lazyNew('PDO')
);

$di->params['MOOP\Model\User'] = array(
	'pdo' => $di->lazyNew('PDO')
);

$di->params['PDO'] = array(
	'dsn'		=> 'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['name'],
	'username'	=> $config['database']['user'],
	'passwd'	=> $config['database']['pass']
);