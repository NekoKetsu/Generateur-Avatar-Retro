<?php
include('Avatar.class.php');	
class AvatarRetro extends Avatar{


	public function __construct($size,$pixel = null,$colors = null,$filter = null){
		parent::__construct($size,$pixel,$colors,$filter);
		if (is_array($size) ){$this->initGrille();}
		$this->drawImage();
	}
	
	public function initSize($size,$pixel){
		$this->taille_x = $size != null ? $size[0] : 150;
		$this->taille_y = $size != null ? $size[1] : 150;
		
		$this->pixel_x = $pixel != null ? $pixel[0] : $size[0]/10;
		$this->pixel_y = $pixel != null ? $pixel[1] : $size[1]/10;
		
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
	
	private function initGrille(){
		for ($x = 0 ; $x < ($this->taille_x/$this->pixel_x)/2 ; $x++)	{
			for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
				$n = rand(10,100);
				$m = rand(65,80);
				$b = ((($this->taille_x/$this->pixel_x)-1)-$x);
				
				$this->grille[$x][$y] = ($n > $m ? $this->secondary_color : $this->primary_color);
				$this->grille[$b][$y] = ($n > $m ? $this->secondary_color : $this->primary_color);
			}
		}	
	}	
}
?>