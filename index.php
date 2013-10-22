<?php
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
	

// Default Page
$route = '/';
$app->get($route, function () {
    
});	

//  MySQL to API
include "methods/mysql-to-api.php";

// Local JSON to API
include "methods/json-to-api.php";

$app->run();	

?>