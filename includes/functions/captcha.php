<?php
function  create_image()
{
    global $image;
    $image = imagecreatetruecolor(150, 30);
    $background_color = imagecolorallocate($image, 74, 78, 112);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    $pixel_color = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);
	$v = 0;
	for ($nm = 1; $nm < 5; $nm++)
	{
		$v += 28;
		for ($x = $v; $x < ($v + 2); $x++)
		{
			for ($i = 0; $i < 1000; $i++)
			{
			imagesetpixel($image, $x, $i, $pixel_color);
			}
		}
		$v += 2;
	}
	for ($x = 60; $x < 90; $x++)
	{
			for ($i = 0; $i < 31; $i++)
			{
				imagesetpixel($image, $x, $i, $pixel_color);
			}
	}
    $letters = '01234';
    $len = strlen($letters);
    $letter = $letters[rand(0, $len - 1)];
    $text_color = imagecolorallocate($image, 255, 255, 255);
    $word = "";
	$word2 = "";
	$font = './font/Square.ttf';
    for ($i = 0; $i < 2; $i++) {
        $letter = $letters[rand(0, $len - 1)];
        //imagestring($image, 7, 11 + ($i * 30), 7, $letter, $text_color);
		if ($letter == 1)
			imagettftext($image, 20, 0, 12 + ($i * 30), 25, $text_color, $font, $letter);
		else
			imagettftext($image, 20, 0, 8 + ($i * 30), 25, $text_color, $font, $letter);
        $word .= $letter;
    }
	$adition = 0;
	$adition_color = imagecolorallocate($image, 74, 78, 112);
	if (rand(0, 1) == 1 || $word < 30)
	{
		$adition = 1;
		$letter = '+';
        //imagestring($image, 7, 5 + ($i * 32), 7, $letter, $adition_color);
		imagettftext($image, 20, 0, 8 + ($i * 30), 25, $adition_color, $font, "+");
	}
	else
	{
		$adition = 0;
		$letter = '-';
		//imagestring($image, 7, 5 + ($i * 32), 7, $letter, $adition_color);
		imagettftext($image, 20, 0, 8 + ($i * 30), 25, $adition_color, $font, "-");
	}
	for ($i = 3; $i < 5; $i++) {
        $letter = $letters[rand(0, $len - 1)];
		//imagestring($image, 7, 13 + ($i * 30), 7, $letter, $text_color);
		if ($letter == 1)
			imagettftext($image, 20, 0, 12 + ($i * 30), 25, $text_color, $font, $letter);
		else
			imagettftext($image, 20, 0, 8 + ($i * 30), 25, $text_color, $font, $letter);
        $word2 .= $letter;
    }
	if ($adition == 1)
		$_SESSION['captcha_string'] = ($word + $word2);
	else
		$_SESSION['captcha_string'] = ($word - $word2);
    $images = glob("*.png");
    foreach ($images as $image_to_delete) {
        @unlink($image_to_delete);
    }
    imagepng($image, "image" . $_SESSION['count'] . ".png");
}
?>