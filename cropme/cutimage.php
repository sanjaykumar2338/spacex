<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require './ImageManipulator.php';

$im = new ImageManipulator('./kida.jpg');

$x1 = 110;
$y1 = 88;
$x2 = 289;
$y2 = 245;

$im->crop($x1, $y1, $x2, $y2); 

//print_r($im); die;
$im->save('./gotit/mains.png');