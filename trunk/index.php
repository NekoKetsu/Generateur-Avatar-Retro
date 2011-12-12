<?php
//header("Content-type: image/png");

function __autoload($class_name) {
    include $class_name . '.class.php';
}
$size = array(200,150);
$pixel = array(10,10);
$image = new SpaceInvader(400,array());
$d = serialize($image);
$c = $image->Hash();
echo $d."</br></br></br>".$c;
imagepng($image->Image());

?>