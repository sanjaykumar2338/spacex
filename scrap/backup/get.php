<?php
require __DIR__ . '/vendor/autoload.php';

use Goutte\Client;

$client = new Client();

// Go to the symfony.com website
$crawler = $client->request('GET', $_POST['url']);

foreach ($crawler as $domElement) {
    $data = $domElement->nodeValue;	
}
$data = explode(',',$data);
$a = [];
foreach($data as $val){
	if (strpos($val, 'https://lh3.googleusercontent.com') !== false) {
		if(!in_array($val,$a)){
		  if(strlen($val) > 150){		  	
			$a[] = $val;
		  }
		}
	}
}

$final = [];
foreach($a as $row){
	$last = explode('"', $row);
	$final[] = $last[1]; 
	
}

$b['test'] = $final;
echo json_encode($b);