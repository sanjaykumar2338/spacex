<?php
$file_info = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $file_info->buffer(file_get_contents($_POST['url']));
$names = explode('/', $mime_type);

$url = $_POST['url'];
$name = time();
$img = './gotit/'.$name.'.'.end($names);

file_put_contents($img, file_get_contents($url));

echo $name.'.'.end($names);
die;