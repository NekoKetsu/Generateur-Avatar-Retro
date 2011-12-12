<?php
//header("Content-type: image/png");

function __autoload($class_name) {
    include $class_name . '.class.php';
}

$image = new AvatarRetro();


imagepng($image->Image());

?>