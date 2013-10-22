<?php

// Set the URL Path
$route = '/productsfrompublicgooglespreadsheet/';
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

	$fieldname = '$t';
	$spreadsheetkey = "0AmRmiTou7vbjdGFIc0U5WEJVRVdFNFFJOUJaOThka2c";	
	
	// Load Service Worksheet
	$producturl = 'http://spreadsheets.google.com/feeds/list/' . $spreadsheetkey . '/1/public/values?alt=json';
	$productfile= file_get_contents($producturl);
	$productfile = str_replace('gsx$','',$productfile);
	$productjson = json_decode($productfile);
	$productrows = $productjson->{'feed'}->{'entry'};

	$Products = array();
	  
	foreach($productrows as $productrow) 
		{
			
		// Pull Each Record	
		$ID = $productrow->productid->$fieldname;
		$Name = $productrow->name->$fieldname;
		$Price = $productrow->price->$fieldname;
		$Description = $productrow->description->$fieldname;
						
		// Filter by Query
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