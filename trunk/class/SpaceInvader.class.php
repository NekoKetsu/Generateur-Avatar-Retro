<?php
require_once('Avatar.class.php');
class SpaceInvader extends Avatar {

	private $spaceInvaderModel = null;
	
	public function __construct($size,$pixel = null,$colors = null,$filter = null){
		parent::__construct($size,$pixel,$colors,$filter);
		if (is_array($size)){
			$this->spaceInvaderModel = array(array(0,0,1,0,0,0),
								 	array(0,0,0,1,0,0),
								 	array(0,0,1,1,1,1),
								 	array(0,1,1,0,1,1),
								 	array(1,1,1,1,1,1),
								 	array(1,0,1,1,1,1),
								 	array(1,0,1,0,0,0),
								 	array(0,0,0,1,1,0));
			
			$this->initSpaceInvader();
		}
		$this->drawImage($filter);
	}
	
	public function initColorList(){
		$this->colorList = array(
			imagecolorallocate($this->image,255,0,0), //"red" => 
			imagecolorallocate($this->image,0,255,0), //"green" => 
			imagecolorallocate($this->image,0,0,255), //"blue" => 
			imagecolorallocate($this->image,131,53,130), //"purple" => 
			imagecolorallocate($this->image,255,186,26), //"orange" => 
			imagecolorallocate($this->image,0,0,0), //"black" => 
			imagecolorallocate($this->image,249,237,4), //"yellow" => 
			imagecolorallocate($this->image,217,131,36) //"maroon" => 
		);
	}	
	
	public function initSize($size,$pixel){
		$this->taille_x = ($size[0] % 11 != 0 ? intval($size[0]/11) * 11 : $size[0]);
		$this->taille_y = intval($size[0]/11) * 8;
		
		$this->pixel_x = $this->taille_x / 11;
		$this->pixel_y = $this->taille_y / 8;
	}
	
	private function initSpaceInvader(){
		$b = (($this->taille_x/$this->pixel_x)-1);
		for ($x = 0 ; $x <= (($this->taille_x/$this->pixel_x)/2) ; $x++)	{
			for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
				$this->grille[$x][$y] = $this->spaceInvaderModel[$y][$x] == 0 ? $this->primary_color : $this->secondary_color;
				
				if ($b > $this->taille_x/$this->pixel_x/2){
					$this->grille[$b][$y] = $this->spaceInvaderModel[$y][$x] == 0 ? $this->primary_color : $this->secondary_color;
				
				}
			}
			$b--;
		}	
	}	
} 
?>