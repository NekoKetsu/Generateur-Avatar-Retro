<?php
header("Content-type: image/png");

function __autoload($class_name) {
    include $class_name . '.class.php';
}
$size = array(200,150);
$pixel = array(10,10);
$image = new AvatarRetro($size);
//var_dump($image);
//echo $image->Hash();

imagepng($image->Image());
?>