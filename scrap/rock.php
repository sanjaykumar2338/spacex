<?php
require __DIR__ . '/vendor/autoload.php';

use Goutte\Client;

$client = new Client();

// Go to the symfony.com website
$crawler = $client->request('GET',$_POST['url']);
//print_r($crawler); die;
foreach ($crawler as $domElement) {
    $data = $domElement->nodeValue;	
}

$images = $data;
$data = explode('window.addEventListener',$data);
$key = explode(',', $data[3]);
$a = [];

foreach($key as $val){
	if (strpos($val, 'https') !== false) {				
		$a[] = $val;		
	}
}

$main = explode('/', $a[2]);
$ret = explode('?key',$main[4]);
$first = $ret[0];
$second = substr($ret[1], 1, -1);
$feek = substr($second, 3);
$needle = mb_substr($first, 0, 6);

$b = [];
foreach($data as $val){	
	$dataa =  explode('[', $val);	
	foreach ($dataa as $value) {
		$ppp = substr($value, 1, -1);
		$b[] = $ppp;
	}		
}

$fast = [];
foreach ($b as $value) {	
	$ok = str_replace('"', '', $value);
	if(strlen($ok) == 44 && strpos($value, $needle) ===0){
		$url = 'https://photos.google.com/share/'.$first.'/photo/'.$ok.'?key='.$feek;
		$fast[] = $url;
	}
}


$data = '';
$data = explode(',',$images);
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


$bbbbb['test'] = $final;
$bbbbb['guest'] = $fast;
echo json_encode($bbbbb);
