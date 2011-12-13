<?php
header("Content-type: image/png");

function __autoload($class_name) {
    include $class_name . '.class.php';
}
$size = array(150,100);
$pixel = array(10,10);

$image = rand(0,100) <= 92 ? new AvatarRetro('P6S5X150Y100x15y10G€P"@™ ‚d@ ') : new SpaceInvader('P6S5X150Y100x15y10G€P"@™ ‚d@ ');
imagepng($image->Image());
?>