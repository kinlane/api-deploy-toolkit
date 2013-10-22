<?php

// Database Settings
$dbserver = "laneworks.cjgvjastiugl.us-east-1.rds.amazonaws.com";
$dbname = "deploy";
$dbuser = "kinlane";
$dbpassword = "ap1stack!";

// Make a database connection
mysql_connect($dbserver,$dbuser,$dbpassword) or die('Could not connect: ' . mysql_error());
mysql_select_db($dbname);

// Set the URL Path
$route = '/productsfrommysql/';
$app->get($route, function ()  use ($app){
				
	// Input Query Parameter
	if(isset($_REQUEST['query'])){ $query = urldecode($_REQUEST['query']); } else { $query = '';}

	// Build SQL Statement
	$Query = "SELECT ID,Name,Price,Description FROM products";
	$Query .= " WHERE Name LIKE '%" . $query . "%' OR Description LIKE '%" . $query . "%'";
	$Query .= " ORDER BY Name DESC";
	$Query .= " LIMIT 25";

	$ProductResult = mysql_query($Query) or die('Query failed: ' . mysql_error());

	$Products = array();
	  
	while ($Product = mysql_fetch_assoc($ProductResult))
		{
		
		// Pull Each Record	
		$ID = $Product['ID'];	
		$Name = $Product['Name'];
		$Price = $Product['Price'];
		$Description = $Product['Description'];
		
		// Build Product Array
		$P = array();											
		$P['ID'] = $ID;
		$P['Name'] = $Name;
		$P['Price'] = $Price;
		$P['Description'] = $Description;
		
		array_push($Products, $P);				
		}	
	
	// Return JSON
	$app->response()->header("Content-Type", "application/json");
	echo json_encode($Products);	

});

?>