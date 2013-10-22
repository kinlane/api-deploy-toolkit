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

// Github JSON to API
include "methods/github-json-to-api.php";

// Github JSON to API
include "methods/public-google-spreadsheet-to-api.php";

$app->run();	

?>