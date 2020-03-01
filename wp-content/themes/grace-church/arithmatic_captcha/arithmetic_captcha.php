<?php
/*session_start();

$nr1 = mt_rand(1000,9999); //mt_rand($min, $max)
$math = "$nr1";
$_SESSION['answer'] = $nr1;
*/
session_start();
/*
	we create out image from the existing jpg image.
	You can replace that image with another of the 
	same size.
*/
$img=imagecreatefromjpeg("texture.jpg");	
/*
	defines the text we use in our image,
	in our case the security number defined
	in index.php
*/

//$security_number = mt_rand(10000,99999); //mt_rand($min, $max)

$length = 5;
$security_number = substr(str_shuffle("123456789abcdefghijklmnpqrstuvwxyz"), 0, $length);

$math = "$security_number";
$_SESSION['answer'] = $security_number;

//$security_number = empty($_SESSION['security_number']) ? 'error' : $_SESSION['security_number'];
$image_text=$security_number;	
/*
	we define 3 random numbers that will
	eventually create our text color code (RGB)
*/
$red=rand(71,255); 
$green=rand(71,255);
$blue=rand(71,255);
/*
	in order to have different color for our text, 
	we substract from the maximum 255 the random
	number generated above
*/
$text_color=imagecolorallocate($img,0,0,0);

/*
	this adds the text stored in $image_text to our 
	capcha image
*/
$text=imagettftext($img,16,rand(-8,8),8,rand(20,30),$text_color,"courbd.ttf",$image_text);
/*
	we tell the browser that he's dealing
	with a jpg image, although that's not true,
	he will have to belive us
*/
header("Content-type:image/jpeg");
header("Content-Disposition:inline ; filename=secure.jpg");	
imagejpeg($img);
/* and this is all.*/
