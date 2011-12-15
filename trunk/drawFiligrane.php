<?php
include_once('api.core.php');
$api = new ImgAPI();
if (isset($_REQUEST['filimgdir']) && isset($_REQUEST['filimgtext']) && isset($_REQUEST['filimgcolor']) && isset($_REQUEST['filimgposition']) && isset($_REQUEST['filimgopacity']) && isset($_REQUEST['type'])){
	if ($_REQUEST['type'] == "preview_button"){
		$text = array('size'=> 4, 'val' => $_REQUEST['filimgtext']);
		$api->filImage($api->adresse_absolue(1).$api->DATA['filimgdir'].$_REQUEST['filimgdir'],$_REQUEST['filimgposition'],$text,$_REQUEST['filimgcolor'],$_REQUEST['filimgopacity']);
		
		$dirfile = $api->tmpdir().time()*(rand(0,40)/10).'.png';
		imagepng($api->image()->Image(),$dirfile);
		
		$r = array("url"=>$dirfile);
		print json_encode($r);
		
	}else if ($_REQUEST['type'] == "save_button"){
		$r ="";
		foreach($api->DATA as $key => $val){
			$r .= $key." ".$_REQUEST[$key]."\n";
		}
		if ($api->saveData($r)){
			print json_encode(1);
		}else{
			print json_encode(0);
		}
			
	}
}else if(isset($_GET['img'])){
	header("Content-type: image/png");
	$text = array('size'=> $api->DATA['filimgtextsize'], 'val' => $api->DATA['filimgtext']);
	if (file_exists($api->imgdir().str_replace('/','',$_GET['img']))){
		$api->filImage($api->adresse_absolue(1).$api->imgdir().str_replace('/','',$_GET['img']),$api->DATA['filimgposition'],$text,$api->DATA['filimgcolor'],$api->DATA['filimgopacity']);
		imagepng($api->image()->Image());
	}
	
}

?>