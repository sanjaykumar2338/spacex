<?php
sleep(2);

$asin  = $_POST['asin'];
$url = 'https://amazonsoldout.com/legendaryanalysis.com/extension/aws.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            "asin=".$asin);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);

$data['test'] = json_decode($server_output);

echo json_encode($data);
die;
?>