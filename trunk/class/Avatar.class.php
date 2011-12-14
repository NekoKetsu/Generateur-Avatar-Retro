<?php

			
abstract class Avatar{
	
	protected $colorList;
	protected $colorLabelList = array("red","green","blue","purple","orange","black","yellow","maroon");
	protected $filter;
	protected $primary_color = null;
	protected $secondary_color = null;
	public $grille;
	protected $image;
	
	protected $taille_x;
	protected $taille_y;
	protected $pixel_x;
	protected $pixel_y;
	
	public function __construct($size,$pixel = null,$colors = null,$filter = null){
		
		if (!is_array($size) && $size != null){
			$this->regenAvatar($size);
		}else{
			$this->initSize($size,$pixel);
			$this->Filter($filter);
			$this->image = imagecreate($this->taille_x,$this->taille_y);
			
			$this->initColorList();
			$this->checkColors($colors);
			
		}
	}
	
	abstract function initSize($size,$pixel);
	abstract function initColorList();
	
	public function Primary_color($Pc = null){if ($Pc != null){$this->primary_color = $Pc;}else{return $this->primary_color;}}
	public function Secondary_color($Sc = null){if ($Sc != null){$this->secondary_color = $Sc;}else{return $this->secondary_color;}}
	public function Taille_x($Tx = null){if ($Tx != null){$this->taille_x = $Tx;}else{return $this->taille_x;}}
	public function Taille_y($Ty = null){if ($Ty != null){$this->taille_y = $Ty;}else{return $this->taille_y;}}
	public function Pixel_x($Px = null){if ($Px != null){$this->pixel_x = $Px;}else{return $this->pixel_x;}}
	public function Pixel_y($Py = null){if ($Py != null){$this->pixel_y = $Py;}else{return $this->pixel_y;}}
	public function Image($Img=null){if ($Img != null){ $this->image = $Img; }else{ return $this->image;}}
	public function Filter($filter=null){if ($filter != null){ $this->filter = $filter; }else{ return $this->filter;}}

	
	private function initGrille(){
		for ($x = 0 ; $x < ($this->taille_x/($this->pixel_x/2)) ; $x++)	{
			for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
				$n = rand(10,100);
				$m = rand(65,80);
				$b = ((($this->taille_y/$this->pixel_y)-1)-$x);
				
				$this->grille[$x][$y] = ($n > $m ? $this->secondary_color : $this->primary_color);
				$this->grille[$b][$y] = $this->grille[$x][$y];
			}
		}	
	}
	public function drawImage(){
		if ( $this->filter == "degrade"){
			ImageFilledRectangle ($this->image,0, 0, $this->taille_x, $this->taille_y, $this->primary_color);
			for ($x = 0 ; $x < ($this->taille_x/$this->pixel_x) ; $x++)	{
				for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
					ImageFilledRectangle ($this->image, 1+ $x * $this->pixel_x, $y * $this->pixel_y, $x*$this->pixel_x +$x , $y*$this->pixel_y+$y, $this->secondary_color);
				}
			}
		}else{
			for ($x = 0 ; $x < ($this->taille_x/$this->pixel_x) ; $x++)	{
				for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
					ImageFilledRectangle ($this->image, $x * $this->pixel_x, $y * $this->pixel_y, $x*$this->pixel_x + $this->pixel_x, $y*$this->pixel_y + $this->pixel_y, $this->grille[$x][$y]);
				}
			}
		}
	}
	
	private function checkColors($colors){

		/* Si (pas de primaire Xor une couleur est renseignée)
		   Car dans tous les cas si une couleur est renseignée, on peut lui attribuer*/
		if (($this->primary_color != null) ^ ($colors[0] != 'null')){
			$this->primary_color = $this->colorList[$colors[0]];
		}else{
			$this->primary_color = $this->colorList[rand(0,(count($this->colorList)-1))];
		}

		/* Si (primaire = secondaire Xor pas de secondaire)
		   Car dans tous les cas si une couleur est renseignée, on peut lui attribuer*/
		if (($this->primary_color == $this->secondary_color) ^ ($this->secondary_color == null)){
			$this->secondary_color = $colors[1] != 'null' ? $this->colorList[$colors[1]] : $this->colorList[rand(0,(count($this->colorList)-1))];
			$this->checkColors();
		}
	}	
										
	
	private function regenAvatar($hashCode){
		preg_match('#X(\d*)#',$hashCode,$m);
		$this->taille_x = $m[1];
		preg_match('#Y(\d*)#',$hashCode,$m);
		$this->taille_y = $m[1];
		
		$this->image = imagecreate($this->taille_x,$this->taille_y);
		
		$this->initColorList();
		
		preg_match('#x(\d*)#',$hashCode, $m);
		$this->pixel_x = $m[1];
		preg_match('#y(\d*)#',$hashCode, $m);
		$this->pixel_y = $m[1];
		preg_match('#P(\d)#',$hashCode, $m);
		$this->primary_color = $this->colorList[$m[1]];
		preg_match('#S(\d)#',$hashCode, $m);
		$this->secondary_color = $this->colorList[$m[1]];
		preg_match('#G(.*)#',$hashCode, $m);
		$hashGrille = $this->asc2bin($m[1]);
		$i = 0;
		for ($x = 0 ; $x < ($this->taille_x/$this->pixel_x) ; $x++)	{
			for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
				$this->grille[$x][$y] = ($hashGrille[$i] == 0 ?  $this->primary_color : $this->secondary_color);
				$i++;
			}
		}	
		
	}
	
	function asc2bin($in){
		$out = '';
		for ($i = 0, $len = strlen($in); $i < $len; $i++){
			$out .= sprintf("%08b",ord($in{$i}));
		}
		return $out;
	}
} 
?>