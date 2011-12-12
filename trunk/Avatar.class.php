<?php
			
abstract class Avatar{
	
	protected $colorList;
	protected $filter;
	protected $primary_color = null;
	protected $secondary_color = null;
	protected $grille;
	protected $image;
	
	public function __construct(){}
	
	public function Image($image=null){if ($image != null){ $this->image = $image; }else{ return $this->image;}}
	public function Filter($filter=null){if ($filter != null){ $this->filter = $filter; }else{ return $this->filter;}}
	
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
	
	public function checkColors(){
		$this->primary_color = $this->primary_color == null ? $this->colorList[rand(0,(count($this->colorList)-1))] : $this->primary_color ;

		if (($this->primary_color == $this->secondary_color) || ($this->secondary_color == null)){
			$this->secondary_color = $this->colorList[rand(0,(count($this->colorList)-1))];
			$this->checkColors();
		}
	}	
	public function Hash(){
		
	}
} 
?>