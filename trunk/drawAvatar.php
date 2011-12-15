<?php
xdebug_enable();
include_once('api.core.php');
$api = new ImgAPI();
if (isset($_REQUEST['taille_x']) && isset($_REQUEST['taille_y']) && isset($_REQUEST['pixel_x']) && isset($_REQUEST['pixel_y']) && isset($_REQUEST['color_p']) && isset($_REQUEST['color_s']) && isset($_REQUEST['type']) && isset($_REQUEST['filter'])){
	
	$size = array($_REQUEST['taille_x'],$_REQUEST['taille_y']);
	$pixel = array($_REQUEST['pixel_x'],$_REQUEST['pixel_y']);
	$colors = array($_REQUEST['color_p'],$_REQUEST['color_s']);
	$filter = $_REQUEST['filter'];
	
	$api->createAvatar($_REQUEST['type'],$size,$pixel,$colors,$filter);

	$dirfile = $api->tmpdir().time()*(rand(0,40)/10).'.png';
	imagepng($api->image()->Image(),$dirfile);
	$r = array("url"=>$dirfile, "hash"=>urlencode($api->Hash($api->image())));
	print json_encode($r);
	
}else if (isset($_GET['img']) && !empty($_GET['img'])){
	header("Content-type: image/png");
	$api->createAvatar(null,$_GET['img']);
	imagepng($api->image()->Image());
}else{
	header("Location:"+$api->getSysUrl());
}

?>