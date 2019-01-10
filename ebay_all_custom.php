<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
require 'simple_html_dom.php';
  
use Goutte\Client;
  
$client = new Client();
  
$main_data = [];
  
// Go to the symfony.com website
$crawler = $client->request('GET', $_POST['url']);
  
foreach ($crawler as $domElement) {
    $data = $domElement->nodeValue;  
}

//for category id
$category_ids = explode('targetingParameters',$data);
$category_ids = explode(':',$category_ids[1]);
$category_ids = explode(',',$category_ids[3]); 
$main_cate_id = [];
foreach($category_ids as $ct){
  preg_match_all('!\d+!', $ct, $matches);
  $category_ids = $matches[0][0]; 
  if($category_ids){
     $main_cate_id[] = $category_ids;
  }
}

//discount price
$binPriceOnly = explode('binPriceOnly', $data); 
$binPriceOnly = explode(',', $binPriceOnly[1]); 
$binPriceOnly = trim(preg_replace("/[^0-9,.]/",'',$binPriceOnly[0]));
 
$very_price = explode('US $', $data);
$product_identifiers = explode('About this product', $data); 
$product_identifiers_2 = $product_identifiers[3];
 
$ePID = explode('epid', $data); 
$ePID_2 = explode('&',$ePID[1]);
$ePID_3 = $ePID_2[0];

$ePID_3 = explode(',', $ePID_3);
$ePID_3 = $ePID_3[0];


$pricing = explode('Now', $data);
$main = explode('Item specifics', $data);  
   
//for category id 
$raw = explode('if ((typeof (oGaugeInfo) !', $main[1]);
$for_category_id = explode('Listed in category:', $main[0]);
$for_category = explode('>', $for_category_id[1]);
  
  
//for price
$list_price = explode(" ", $pricing[1]);
if($list_price[1] == 'price.You'){
  $list_price[1] = "";
}
 
$pi_check = trim(preg_replace("/[^0-9,.]/",'', $list_price[1]));
 
if(!$pi_check){    
  $very_price =  explode(' ', $very_price[1]);    
  $list_price[1] =  trim(preg_replace("/[^0-9,.]/",'', $very_price[0]));
}


//for description
$for_descption = explode('Seller Notes:',$raw[0]);
$for_descption = explode('”', $for_descption[1]);
 
//for mpn number
$for_mpn = explode('MPN:',$raw[0]);
$for_mpn_2 = explode(' ', $for_mpn[1]); 
 
//for mpn number
$for_color = explode('Color:',$raw[0]);
$for_color_2 = explode(' ', $for_color[1]); 
 
//for UPC number
$for_upc = explode('UPC:',$raw[0]);
$for_upc_2 = explode(' ', $for_upc[1]); 
//print_r(preg_replace("/[^0-9,.]/", "", $for_upc_2)); die;
  
//for brand and description
$for_brand = explode('Camera Resolution:',$raw[0]);
$brand = explode("Brand:", $for_brand[0]);
$original_brand_2 = explode(" ", $brand[1]);


 
//print_r($original_brand_2); die;
 
if(is_array($original_brand_2) && count($original_brand_2) < 0){  
  $brand = explode("Brand:", $for_brand[1]);   
  $original_brand_2 = explode(" ", $brand[1]);  
}

//for model number
$for_model = explode("Model:", $raw[0]);
$model_2 = explode(" ", $for_model[1]);
 
//check for description 
if(!trim(preg_replace('/\t\s+/','', $brand[0]))){
    $get_desc = explode('Product Identifiers',$product_identifiers_2);
    $brand[0] = $get_desc[0];   
}
 
//check for brand 
if(!trim(preg_replace('/\t\s+/','', $original_brand_2[2]))){	
    $get_desc  = explode('Product Identifiers',$product_identifiers_2);
    $get_brand = explode('Brand', $get_desc[1]);     
    $get_brand_2 = explode('MPN', $get_brand[1]);       
    $original_brand_2[2] = $get_brand_2[0];
}else{
	$original_brand_2[2] = $original_brand_2[2];
}

//check for color
if(!trim(preg_replace('/\t\s+/','',$for_color_2[2]))){
    $get_desc  = explode('Product Identifiers',$product_identifiers_2);     
    $get_color = explode('Color', $get_desc[1]);     
    $get_color_2 = explode('Model', $get_color[1]);   
    $for_color_2[2] = $get_color_2[0];
}
 
//check for mpn
if(!trim(preg_replace('/\t\s+/','',$for_mpn_2['2']))){
    $get_desc  = explode('Product Identifiers',$product_identifiers_2);       
    $get_model = explode('MPN', $get_desc[1]);    
    $get_model_2 = explode('Model', $get_model[1]);   
    $for_mpn_2['2'] = $get_model_2[0];
}
 
//check for upc
if(!trim(preg_replace('/\t\s+/','',$for_upc_2['2']))){
  $get_desc  = explode('Product Identifiers',$product_identifiers_2); 
  $get_model = explode('UPC', $get_desc[1]);    
  $get_model_2 = explode('Model', $get_model[1]);   
  $for_upc_2['2'] = $get_model_2[0];
}
 
//check for epid
if(!trim(preg_replace('/\t\s+/','',$ePID_3))){  
  $get_desc  = explode('Product Identifiers',$product_identifiers_2); 
  $get_model = explode('(ePID)', $get_desc[1]);    
  $get_model_2 = explode('Product', $get_model[1]);   
   
  $ePID_3 = $get_model_2[0];
}
 
//check for model
if(!trim(preg_replace('/\t\s+/','',$model_2[2]))){
  $get_desc  = explode('Product Identifiers',$product_identifiers_2); 
 
  $get_model = explode('Model', $get_desc[1]);    
  $get_model_2 = explode('eBay', $get_model[1]);   
   
  $model_2[2] = $get_model_2[0];
}

if($for_descption[0] && strpos($for_descption[0],"BELOW!")){
  $for_descption[0] = '';
}
 
$main_data['description'] = $for_descption[0];//getdescription();
$brand_val = trim(preg_replace('/\t\s+/', '', $original_brand_2[2]));
$brand_val = str_replace("For","",$brand_val);
$main_data['brand'] = $brand_val;
 
 
if(trim(preg_replace('/\t\s+/', '', $for_color_2[2])) == 'Space'){ 
  $color_val = trim(preg_replace('/\t\s+/', '', $for_color_2[2])).' '.trim(preg_replace('/\t\s+/', '', $for_color_2[3]));
  $color_val = str_replace("Multi","",$color_val);
  $main_data['color'] = str_replace("For","",$color_val);
}else{
  if(trim(preg_replace('/\t\s+/', '', $for_color_2[2])) == 'See'){
	$main_data['color'] = ''; 
  }else{
	$color_val = trim(preg_replace('/\t\s+/', '', $for_color_2[2]));
	$main_data['color'] = str_replace("For","",$color_val);
	$main_data['color'] = str_replace("Multi","",$color_val);		
  }
}

$mpn_val = trim($for_mpn_2['2']) == 'Does' ? '' : trim(preg_replace('/\t\s+/', '',$for_mpn_2['2']));
 
$main_data['mpn'] = str_replace(",","",$mpn_val);
$main_data['upc'] = trim($for_upc_2['2']) == 'Does' ? '' : trim(preg_replace("/[^0-9,.]/",'',$for_upc_2['2']));
$main_data['epid'] = preg_replace("/[^0-9,.]/",'',$ePID_3);

//print_r($model_2); die;
 
if(trim($model_2[5]) == 'Capacity:' || trim($model_2[5]) == 'Contract:' || trim($model_2[5]) == 'MPN:' || trim($model_2[5]) == 'Processor:'){
$main_data['model'] = trim(preg_replace('/\t\s+/', '', $model_2[2])).' '.trim(preg_replace('/\t\s+/', '', $model_2[3])).' '.trim(preg_replace('/\t\s+/', '', $model_2[4]));
$model_val = str_replace("Storage","",$main_data['model']);
$model_val = str_replace("UPC:","",$model_val);
$model_val = str_replace("Operating","",$model_val);
$model_val = str_replace(", For","",$model_val);
$model_val = str_replace("For","",$model_val);
$model_val = str_replace("Manufacturer","",$model_val);
$model_val = str_replace("Manufacturer","",$model_val);
$model_val = str_replace("MPN:","",$model_val);
$model_val = str_replace("Material:","",$model_val);
$model_val = str_replace("Brand:","",$model_val);

$main_data['model'] = $model_val;
}else{	
  if(trim($model_2[2])){
    $main_data['model'] = trim(preg_replace('/\t\s+/', '', $model_2[2])).' '.trim(preg_replace('/\t\s+/', '', $model_2[3])).' '.trim(preg_replace('/\t\s+/', '', $model_2[4])).' '.trim(preg_replace('/\t\s+/', '', $model_2[5]));  
	$model_val = str_replace("Storage","",$main_data['model']);
    $model_val = str_replace("UPC:","",$model_val);
	$model_val = str_replace("Operating","",$model_val);
	$model_val = str_replace(", For","",$model_val);
	$model_val = str_replace("For","",$model_val);
	$model_val = str_replace("Manufacturer","",$model_val);
	$model_val = str_replace("MPN:","",$model_val);
	$model_val = str_replace("Material:","",$model_val);
	$model_val = str_replace("Brand:","",$model_val);
	
    $main_data['model'] = $model_val;
  }else{
    $main_data['model'] = $model_2[2];
  }
}
 
if($binPriceOnly){
  $list_price[1] = $binPriceOnly;
}
 

$main_data['list_price'] = trim(preg_replace('/\t\s+/', '', $list_price[1]));
$main_data['category'] = trim(preg_replace('/\t\s+/', '',$for_category[0]));
//$main_data['epids'] = epid($raw[0]);
$main_data['cat_id'] = end($main_cate_id); //get_category_id($_POST['url']); 

$other_data = getdescription();
$main_data['title'] = $other_data['title'];
$main_data['images'] = $other_data['images'];

  
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

function getdescription(){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://moxycrm.com/users/getdetails");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,
            "url=".$_POST['url']);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);

	curl_close ($ch);

	$data = json_decode($server_output,true); 

	return $data;
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

function epid($raw){
//for epid number
 $for_epid = explode('ePID)',$raw);
 $for_epid_2 = explode(' ', $for_epid[1]); 
 $for_epid_3 = trim(preg_replace('/\t\s+/', '', $for_epid_2[0])); 
 $for_epid_4 = (string) $for_epid_3;
 preg_match_all('!\d+!', $for_epid_4, $matches);
 $epid_final = $matches[0][0];
 return $epid_final;
}