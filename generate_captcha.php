<?php
session_start();

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$captcha_text = generateRandomString();
$_SESSION['captcha'] = $captcha_text;

$image = imagecreate(120, 40);
$background_color = imagecolorallocate($image, 255, 255, 255); // White background
$text_color = imagecolorallocate($image, 0, 0, 0); // Black text

// Add some random lines
for ($i = 0; $i < 5; $i++) {
    imageline($image, 0, rand() % 40, 120, rand() % 40, imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255)));
}

// Add some random pixels
for ($i = 0; $i < 500; $i++) {
    imagesetpixel($image, rand() % 120, rand() % 40, imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255)));
}

imagestring($image, 5, 20, 10, $captcha_text, $text_color);

header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>