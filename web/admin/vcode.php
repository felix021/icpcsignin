<?php
session_start(); 
srand((double)microtime()*1000000);
$_SESSION['vcode'] = rndstr();

$x = 40;
$y = 22;

$im = @imagecreate($x, $y) or die("Cannot Initialize new GD image stream");
$white = imagecolorallocate($im, 255, 255, 255);
$red = imagecolorallocate($im, 233, 14, 91);
imagestring($im, 5, rand()%5+1, rand()%5+1,  $_SESSION['vcode'], $red);
for($i=0;$i<25;$i++) imagesetpixel($im, rand()%$x , rand()%$y , $red);
header("Content-type: image/PNG");
imagepng($im);
imagedestroy($im);

function rndstr($length=4)
{
  while($length--) $str .= (rand() % 10);
  return $str;
}
?>
