<?php
xdebug_enable();
//header("Content-type: image/png");
include('api.core.php');
$api = new ImgAPI();
$api->FormGenAvatar();


?>