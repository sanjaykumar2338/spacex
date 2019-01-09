<?php
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';
require 'simple_html_dom.php';
 
use Goutte\Client;
 
$client = new Client();
 
$main_data = [];
 
// Go to the symfony.com website
$crawler = $client->request('GET',$_POST['url']);
 
foreach ($crawler as $domElement) {
    $data = $domElement->nodeValue;  
}
 
//print_r($data); die; 
$main = explode('Item specifics', $data);
 
//print_r($main); die; 
$raw = explode('if ((typeof (oGaugeInfo) !', $main[1]);
$for_category_id = explode('Listed in category:', $main[0]);
$for_category = explode('>', $for_category_id[1]);
 
//for category id
 

//for epid number
$for_epid = explode('ePID)',$raw[0]);
$for_epid_2 = explode(' ', $for_epid[1]); 
$for_epid_3 = trim(preg_replace('/\t\s+/', '', $for_epid_2[0])); 
$for_epid_4 = (string) $for_epid_3;
preg_match_all('!\d+!', $for_epid_4, $matches);
$epid_final = $matches[0][0];

$main_data['epid'] = $epid_final;
$main_data['cat_id'] = get_category_id($_POST['url']); 
$face['test'] = $main_data;
echo json_encode($face);
die;
 
function numeric_val($val){        
    if (preg_match_all('/\d+/', $val, $matches)) {      
        return $matches;
    } else {
        return false;
    }
}

function get_category_id($url){
// Create DOM from URL or file
$html = file_get_html($url);
  
//Find all links 
foreach($html->find('a') as $element) {
    if (filter_var($element->href, FILTER_VALIDATE_URL) === FALSE) { 
    }else{
        $link_array = explode('/',$element->href);
        $cat_id = end($link_array);
 
        $domain = get_domain($element->href);
        if($domain == 'ebay.com' && strpos($element->href, '/b/') !== false && is_numeric($cat_id)){
            $main[] = $cat_id ;
        }
    }
} 
	return end($main);
}

function get_domain($url){
  $pieces = parse_url($url);
  $domain = isset($pieces['host']) ? $pieces['host'] : $pieces['path'];
  if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
    return $regs['domain'];
  }
  return false;
}