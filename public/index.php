<?php

session_start();

require_once '../vendor/autoload.php';

$config = require_once('../config.php');

require_once '../services.php';

$framework = $di->newInstance('MOOP\MasterController');
echo $framework->execute();