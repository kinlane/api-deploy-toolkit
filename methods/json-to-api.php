<?php

// Set the URL Path
$route = '/productsfromjson/';
$app->get($route, function ()  use ($app){
				
	// Input Query Parameter
	if(isset($_REQUEST['query']))
		{
		$query = urldecode($_REQUEST['query']);
		$IncludeRecord = 0; 
		} 
	else 
		{
		$query = '';
		$IncludeRecord = 1;
		}

	$ProductString = file_get_contents("data/products.json");
	$ProductJSON = json_decode($ProductString,true);

	$Products = array();
	  
	foreach($ProductJSON as $Product)
		{
		
		// Pull Each Record	
		$ID = $Product['ID'];	
		$Name = $Product['Name'];
		$Price = $Product['Price'];
		$Description = $Product['Description'];
				
		
		if($query!=''){
			if(strpos(strtolower($Name),strtolower($query)) || strpos(strtolower($Description),strtolower($query)))
				{
				$IncludeRecord = 1;
				}
			}	
	
		if($IncludeRecord==1)
			{		
		
			// Build Product Array
			$P = array();											
			$P['ID'] = $ID;
			$P['Name'] = $Name;
			$P['Price'] = $Price;
			$P['Description'] = $Description;
			
			array_push($Products, $P);	
			
			}			
		}	
	
	// Return JSON
	$app->response()->header("Content-Type", "application/json");
	echo json_encode($Products);	

});

?>