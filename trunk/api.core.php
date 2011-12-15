<?php

class ImgAPI{
	
	private $SETTINGS;
	public $DATA;
	private $image;
	
	function __construct(){
		$this->loadSetting();
		$this->loadData();
		$this->purgeTemp();
	}
	
	public function imgdir(){return $this->SETTINGS["imgdir"];}
	public function tmpdir(){return $this->SETTINGS["tmpdir"];}
	public function url(){return $this->SETTINGS["url"];}
	public function data(){return $this->SETTINGS["data"];}
	public function image(){return $this->image;}
	
	private function loadSetting(){
		$f = fopen('api.conf.ini','r');
		while (($buffer = fgets($f, 4096)) !== false) {
			if ($buffer[0] == "#"){ continue;}
			if (preg_match('#load "(\w+)"#',$buffer,$m)){require_once($m[1].'.class.php');continue;}
			if (preg_match('#url "(.+)"#',$buffer,$m)){ $this->SETTINGS['url'] = ($m[1] != null ? $m[1] : adresse_absolue(false,'')); continue;}
			if (preg_match('#imgdir "(.+)"#',$buffer,$m)){ $this->SETTINGS['imgdir'] = $m[1]; continue;}
			if (preg_match('#tmpdir "(.+)"#',$buffer,$m)){ $this->SETTINGS['tmpdir'] = $m[1]; continue;}
			if (preg_match('#tpldir "(.+)"#',$buffer,$m)){ $this->SETTINGS['tpldir'] = $m[1]; continue;}
			if (preg_match('#cldir "(.+)"#',$buffer,$m)){ $this->SETTINGS['cldir'] = $m[1]; continue;}
			if (preg_match('#jsdir "(.+)"#',$buffer,$m)){ $this->SETTINGS['jsdir'] = $m[1]; continue;}
			if (preg_match('#data "(.+)"#',$buffer,$m)){ $this->SETTINGS['data'] = $m[1]; continue;}
			if (preg_match('#tmp_png_time "(.+)"#',$buffer,$m)){ $this->SETTINGS['tmp_png_time'] = $m[1]; continue;}
    	}
		
	}
	
	private function loadData(){
		$f = fopen($this->SETTINGS['data'],'r');
		while (($buffer = fgets($f, 4096)) !== false) {
			if ($buffer[0] == "#"){ continue;}
			if (preg_match('#filimgdir "(.+)"#',$buffer,$m)){ $this->DATA['filimgdir'] = $m[1]; continue;}
			if (preg_match('#filimgtext "(.+)"#',$buffer,$m)){ $this->DATA['filimgtext'] = $m[1]; continue;}
			if (preg_match('#filimgcolor "(.+)"#',$buffer,$m)){ $this->DATA['filimgcolor'] = $m[1]; continue;}
			if (preg_match('#filimgopacity "(.+)"#',$buffer,$m)){ $this->DATA['filimgopacity'] = $m[1]; continue;}
			if (preg_match('#filimgposition "(.+)"#',$buffer,$m)){ $this->DATA['filimgposition'] = $m[1]; continue;}
			if (preg_match('#filimgtextsize "(.+)"#',$buffer,$m)){ $this->DATA['filimgtextsize'] = $m[1]; continue;}
    	}
	}
	
	private function purgeTemp(){
		$d = opendir($this->SETTINGS["tmpdir"]);
		while(false !== ($f = readdir($d))) {
            if(!is_dir($this->SETTINGS["tmpdir"].$f.'/')){
				if(preg_match('#.png#',$f)){
					if((time()-filemtime($this->SETTINGS["tmpdir"].$f))/3600 > $this->SETTINGS["tmp_png_time"])
                 		unlink($this->SETTINGS["tmpdir"].$f);
				}
            }
        } 
        closedir($d);
	}
	
	public function getLink($img){
		return $this->adresse_absolue(1).'drawFiligrane.php?img='.$img;
	}
	
	public function checkNavigateur(){
		if (preg_match('#Firefox#',$_SERVER['HTTP_USER_AGENT']) || preg_match('#MSIE#',$_SERVER['HTTP_USER_AGENT'])){
			return 'firefox';
		}else if (preg_match('#Opera#',$_SERVER['HTTP_USER_AGENT'])){
			return 'opera';
		}else{
			return 'other';
		}
	}
	
	public function createAvatar($type,$size,$pixel=null,$colors=null,$filter=null){
		if ($type != 'SpaceInvader'){
			include_once($this->SETTINGS['cldir'].'AvatarRetro.class.php');
			$this->image = new AvatarRetro($size,$pixel,$colors,$filter);
		}else{
			include_once($this->SETTINGS['cldir'].'SpaceInvader.class.php');
			$this->image = new SpaceInvader($size,$pixel,$colors,$filter);
		}
	}
	public function filImage($image_link,$position,$couleur,$text,$opacity){
		include_once($this->SETTINGS['cldir'].'Filigrane.class.php');
		$this->image = new Filigrane($image_link,$position,$couleur,$text,$opacity);
	}
	
	public function FormGenAvatar(){
		$form = file_get_contents($this->SETTINGS['tpldir'].'formAvatar.html');
		$form = preg_replace('#{_IMGURL}#',$this->SETTINGS['tpldir'].$this->SETTINGS['imgdir'],$form);
		$form = preg_replace('#{_JSURL}#',$this->SETTINGS['tpldir'].$this->SETTINGS['jsdir'],$form);
		$form = preg_replace('#type="range"#',$this->checkNavigateur() == "opera" ? 'type="range"' : 'type="text"',$form);
		$form = preg_replace('#type="color"#',$this->checkNavigateur() == "opera" ? 'type="color"' : 'type="text"',$form);
		echo $form;
	}
	
	public function FormAjoutFiligrane(){
		$form = file_get_contents($this->SETTINGS['tpldir'].'formFiligrane.html');
		$form = preg_replace('#{_IMGURL}#',$this->SETTINGS['tpldir'].$this->SETTINGS['imgdir'],$form);
		$form = preg_replace('#{_JSURL}#',$this->SETTINGS['tpldir'].$this->SETTINGS['jsdir'],$form);
		$form = preg_replace('#{_FILIMGDIR}#',$this->adresse_absolue(1).$this->DATA['filimgdir'],$form);
		$form = preg_replace('#{_FILIMGTEXT}#',$this->DATA['filimgtext'],$form);
		$form = preg_replace('#{_FILIMGCOLOR}#',$this->DATA['filimgcolor'],$form);
		$form = preg_replace('#{_FILIMGOPACITY}#',$this->DATA['filimgopacity'],$form);
		$form = preg_replace('#{_FILIMGPOSITION}#',$this->DATA['filimgposition'],$form);
		$form = preg_replace('#{_FILIMGTEXTSIZE}#',$this->DATA['filimgtextsize'],$form);
		$form = preg_replace('#type="range"#',$this->checkNavigateur() == "opera" ? 'type="range"' : 'type="text"',$form);
		$form = preg_replace('#type="color"#',$this->checkNavigateur() == "opera" ? 'type="color"' : 'type="text"',$form);
		$form = preg_replace('#type="url"#',$this->checkNavigateur() == "opera" ? 'type="url"' : 'type="text"',$form);
		echo $form;
	}
	
	public function saveData(){
		$data = file_get_contents($this->SETTINGS['data']);
		$data = preg_replace('#filimgdir (.+)#',$this->DATA['filimgdir'],$form);
		$data = preg_replace('#filimgtext (.+)#',$this->DATA['filimgtext'],$form);
		$data = preg_replace('#filimgcolor (.+)#',$this->DATA['filimgcolor'],$form);
		$data = preg_replace('#filimgopacity (.+)#',$this->DATA['filimgopacity'],$form);
		$data = preg_replace('#filimgposition (.+)#',$this->DATA['filimgposition'],$form);
		$f = fopen($this->SETTINGS['data'],"w");
		fputs($f,$data,4096);
	}
	
	public function Hash($a){
		$r = "P".$a->Primary_color()."S".$a->Secondary_color()."X".$a->Taille_x()."Y".$a->Taille_y()."x".$a->Pixel_x()."y".$a->Pixel_y()."G".$this->hashGrille($a);
		return $r;
	}
	
	private function hashGrille($avatar){
		$binCode="";
		$hexaCode="";
		for ($x = 0 ; $x < ($avatar->Taille_x()/$avatar->Pixel_x()) ; $x++)	{
			for ($y = 0 ; $y < ($avatar->Taille_y()/$avatar->Pixel_y()) ; $y++) {
				$binCode .= $avatar->grille[$x][$y] == $avatar->Primary_color() ? 0 : 1 ;
			}
		}
		$code = str_split($binCode,8);
		foreach ($code as $key=>$value){
			$hexaCode .= $this->bin2asc($value);
		}
		return $hexaCode;
	}
	private function bin2asc($in){
		$out = '';
		for ($i = 0, $len = strlen($in); $i < $len; $i += 8){
			$out .= chr(bindec(substr($in,$i,8)));
		}
		return $out; 
	}
	public function adresse_absolue($r){
	    if ($r == '1'){
			$dir = preg_split('#/#',$_SERVER['PHP_SELF']);
			$d ="";
			for($i=0;$i<sizeof($dir)-1;$i++){
				$d .= $dir[$i]."/";
			}
			$url="http://".$_SERVER['HTTP_HOST'].$d;
		}else{
			$url="http://".$_SERVER['HTTP_HOST']."/";
		}
	    return $url;
	}
}

?>