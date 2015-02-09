<?php

session_start();

require_once '../vendor/autoload.php';

$config = require_once('../config.php');

$framework = new MasterController($config);
echo $framework->execute();