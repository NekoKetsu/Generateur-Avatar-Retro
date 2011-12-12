<?php
header("Content-type: image/png");

function __autoload($class_name) {
    include $class_name . '.class.php';
}
$size = array(200,150);
$pixel = array(10,10);
$image = new SpaceInvader("P3S5X396Y288x36y36G0000111010011000101111100110110100111101001111000011110101101111101111100101100000001110");
//var_dump($image);
//echo $image->Hash();

imagepng($image->Image());
?>