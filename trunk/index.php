<?php
xdebug_enable();
//header("Content-type: image/png");
include('api.core.php');
$api = new ImgAPI();
echo "<img src=".$api->getLink('1721163867.8.png')."/>";

?>