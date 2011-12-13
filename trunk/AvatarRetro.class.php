<?php
include('Avatar.class.php');	
class AvatarRetro extends Avatar{
	
	# __construct(Array int | int $size,[Array int $pixel = null[,String $colors = null,[String $filter = null]]])
	public function __construct($size,$pixel = null,$colors = null,$filter = null){
		parent::__construct($size,$pixel,$colors,$filter);
		$this->initGrille();
		$this->drawImage($filter);
	}
	
	public function initSize($size,$pixel){
		$this->taille_x = $size[0];
		$this->taille_y = $size[1];
		
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
	
	public function initGrille(){
		for ($x = 0 ; $x < ($this->taille_x/($this->pixel_x/2)) ; $x++)	{
			for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
				$n = rand(10,100);
				$m = rand(65,80);
				$b = ((($this->taille_y/$this->pixel_y)-1)-$x);
				
				$this->grille[$x][$y] = ($n > $m ? $this->secondary_color : $this->primary_color);
				$this->grille[$b][$y] = ($n > $m ? $this->secondary_color : $this->primary_color);
			}
		}	
	}	
}
?>