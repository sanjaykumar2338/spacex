<?php
error_reporting(0);

$url_raw  = urlencode($_POST['url']);

$start_page = isset($_POST['page']) ? $_POST['page'] : 0;

$url = 'https://cse.google.com/cse/element/v1?rsz=filtered_cse&num=10&hl=en&source=gcsc&gss=.com&start='.$start_page.'&cx=006084619413404036248:dl1t-ht6bbw&q='.$url_raw.'&safe=off&cse_tok=AKaTTZiS3Lc529eUlkeSHhRRSYFX:1545841767440&sort=&oq=q='.$url_raw.'&gs_l=partner-generic.12...500721.512859.1.530591.10.10.0.0.0.0.167.1266.0j10.10.0.gsnos%2Cn%3D13...0.12144j44531268j10j1...1.34.partner-generic..11.0.0.hSOB5GvG7LY&callback=google.search.cse.api9345&nocache=154536685303';




//echo $url;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//raw data
$data = curl_exec($ch);
$rs = explode('results', $data);

$str2 = substr($rs[2],3);
$t = substr($str2, 0, -3);
$seach_result = json_decode($t, true);

if(empty($seach_result)){
	$data2['status'] = false;
	$data2['msg'] = 'forbidden: Cse token expire.';
}else{
	$data2['msg'] = '';
	$data2['status'] = true;
}

$data2['test'] = $seach_result;
echo json_encode($data2);
exit();