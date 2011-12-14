<?php

class ImgAPI{
	
	private $SETTINGS;
	
	function __construct(){
		$this->loadSetting();
	}
	public function tmpdir(){
		return $this->SETTINGS["tmpdir"];
	}
	private function loadSetting(){
		$f = fopen('api.conf.ini','r');
		while (($buffer = fgets($f, 4096)) !== false) {
			if ($buffer[0] == "#"){ continue;}
			if (preg_match('#load "(\w+)"#',$buffer,$m)){require_once($m[1].'.class.php');continue;}
			if (preg_match('#imgdir "(.+)"#',$buffer,$m)){ $this->SETTINGS['imgdir'] = $m[1]; continue;}
			if (preg_match('#tmpdir "(.+)"#',$buffer,$m)){ $this->SETTINGS['tmpdir'] = $m[1]; continue;}
			if (preg_match('#tpldir "(.+)"#',$buffer,$m)){ $this->SETTINGS['tpldir'] = $m[1]; continue;}
			if (preg_match('#cldir "(.+)"#',$buffer,$m)){ $this->SETTINGS['cldir'] = $m[1]; continue;}
			if (preg_match('#jsdir "(.+)"#',$buffer,$m)){ $this->SETTINGS['jsdir'] = $m[1]; continue;}
    	}
	}
	
	public function createImage($type,$size,$pixel,$colors,$filter){
		if ($type != 'SpaceInvader'){
			include_once($this->SETTINGS['cldir'].'AvatarRetro.class.php');
			$this->image = new AvatarRetro($size,$pixel,$colors,$filter);
		}else{
			include_once($this->SETTINGS['cldir'].'SpaceInvader.class.php');
			$this->image = new SpaceInvader($size,$pixel,$colors,$filter);
		}
	}
	
	public function FormGenAvatar(){
		$form = file_get_contents($this->SETTINGS['tpldir'].'formAvatar.html');
		$form = preg_replace('#{_IMGURL}#',$this->SETTINGS['tpldir'].$this->SETTINGS['imgdir'],$form);
		$form = preg_replace('#{_JSURL}#',$this->SETTINGS['tpldir'].$this->SETTINGS['jsdir'],$form);
		echo $form;
	}
	public function FormAjoutFiligrane(){echo file_get_contents($this->SETTINGS['tpldir'].'formFiligrane.html');}
	
	public function Hash($avatar){
		$r = "P".$avatar->Primary_color()."S".$avatar->Secondary_color()."X".$avatar->Taille_x()."Y".$avatar->Taille_y()."x".$avatar->Pixel_x()."y".$avatar->Pixel_y()."G".$this->hashGrille($avatar);
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
}

?>