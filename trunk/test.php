<?php
header("Content-type: image/png");

function __autoload($class_name) {
    include $class_name . '.class.php';
}
$size = array(150,100);
$pixel = array(10,10);


imagepng($image->Image());
?>