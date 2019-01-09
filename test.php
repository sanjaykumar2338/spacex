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
$crawler = $client->request('GET','https://www.ebay.com/itm/Apple-iPhone-7-32GB-GSM-Unlocked-Smartphone-/252764834267');
  
foreach ($crawler as $domElement) {
    $data = $domElement->nodeValue;  
}

print_r($data); die;

