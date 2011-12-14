<?php
xdebug_enable();
include_once('api.core.php');
$api = new ImgAPI();
if (isset($_REQUEST['image']) && isset($_REQUEST['position_x']) && isset($_REQUEST['position_y']) && isset($_REQUEST['color']) && isset($_REQUEST['text']) && isset($_REQUEST['text_size']) && isset($_REQUEST['opacity'])){
	
	$position = array($_REQUEST['position_x'],$_REQUEST['position_y']);
	$text = array("val" => $_REQUEST['text'],"size" => $_REQUEST['text_size']);
	$img = array("dir" => $api->imgdir(), "val" => $_REQUEST['image']);
	$api->filImage($img,$position,$_REQUEST['color'],$text,($_REQUEST['opacity'] == "" ? null : $_REQUEST['opacity']));

	$dirfile = $api->tmpdir().time()*(rand(0,40)/10).'.png';
	imagepng($api->image->Image(),$dirfile);
	$r = array("url"=>$dirfile, "hash"=>$api->Hash($image));
	print json_encode($r);
	
}

?>