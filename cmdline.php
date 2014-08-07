<?php

require_once 'vendor/autoload.php';
use Example\Controller;

$controller = new Controller();
$controller->run('/svc/example/add/5/5.json');

