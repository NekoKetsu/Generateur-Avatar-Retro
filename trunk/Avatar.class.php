<?php

			
abstract class Avatar{
	
	protected $colorList;
	protected $colorLabelList = array("red","green","blue","purple","orange","black","yellow","maroon");
	protected $filter;
	protected $primary_color = null;
	protected $secondary_color = null;
	protected $grille;
	protected $image;
	
	protected $taille_x;
	protected $taille_y;
	protected $pixel_x;
	protected $pixel_y;
	
	public function __construct($size,$pixel = null,$colors = null,$filter = null){
	
		if (!is_array($size)){
			$this->regenAvatar($size);
		}else{
			$this->initSize($size,$pixel);
			$this->Filter($filter);
			$this->image = imagecreate($this->taille_x,$this->taille_y);
			
			if ($colors == null){
				$this->initColorList();
				$this->checkColors();
			}else{
				$this->primary_color = $colors[0];
				$this->secondary_color = $colors[0];
			}
		}
	}
	
	abstract function initSize($size,$pixel);
	abstract function initColorList();
	
	public function Image($image=null){if ($image != null){ $this->image = $image; }else{ return $this->image;}}
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
	
	private function checkColors(){
		$this->primary_color = $this->primary_color == null ? $this->colorList[rand(0,(count($this->colorList)-1))] : $this->primary_color ;

		if (($this->primary_color == $this->secondary_color) || ($this->secondary_color == null)){
			$this->secondary_color = $this->colorList[rand(0,(count($this->colorList)-1))];
			$this->checkColors();
		}
	}	
										
	public function Hash(){
		$r = "P".$this->primary_color."S".$this->secondary_color."X".$this->taille_x."Y".$this->taille_y."x".$this->pixel_x."y".$this->pixel_y."G".$this->hashGrille();
		return $r;
	}
	private function hashGrille(){
		$binCode="";
		$hexaCode="";
		for ($x = 0 ; $x < ($this->taille_x/$this->pixel_x) ; $x++)	{
			for ($y = 0 ; $y < ($this->taille_y/$this->pixel_y) ; $y++) {
				$binCode .= $this->grille[$x][$y] == $this->primary_color ? 0 : 1 ;
			}
		}
		
		$code = str_split($binCode,8);
		
		foreach ($code as $key=>$value){
			$hexaCode .= $this->bin2asc($value);
		}
		
		return $hexaCode;
		
	}
	function bin2asc($in){
		$out = '';
		for ($i = 0, $len = strlen($in); $i < $len; $i += 8){
			$out .= chr(bindec(substr($in,$i,8)));
		}
		return $out; 
	}
	function asc2bin($in){
		$out = '';
		for ($i = 0, $len = strlen($in); $i < $len; $i++){
			$out .= sprintf("%08b",ord($in{$i}));
		}
		return $out;
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
} 
?>