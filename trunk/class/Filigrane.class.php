<?php

			
class Filigrane{
	
	private $image;
	private $colorLabelList = array("red","green","blue","purple","orange","black","yellow","maroon");
	
	private $size;
	private $text;
	private $textSize;
	private $position_x;
	private $position_y;
	private $opacity;
	private $color;
	
	
	public function __construct($img,$position,$text,$color,$opacity = null){
		textSize($text["size"]);
		Position($position);
		
		Text($text["val"]);
		Opacity($opacity);
		
		$this->image = checkExtention($img);
		setSize();
		initColorList();
		Color($color);
		
		DrawFiligrane();
	}
	
	public function Text($text = null){ if($text != null){$this->text = $text; }else{ return $this->text;}}
	public function textSize($textSize = null){ if($textSize != null){$this->textSize = $textSize; }else{ return $this->textSize;}}
	public function Position($position = null){ if($position != null){$this->position_x = $position[0];$this->position_y = $position[1]; }else{ return $this->position;}}
	public function Color($couleur = null){ if($couleur != null){$this->couleur = $this->colorList[$couleur]; }else{ return $this->couleur;}}
	public function Opacity($opacity = null){ if($opacity != null){
		$this->opacity = $opacity != null ? $opacity : 100; 
		}else{ return $this->opacity;}}
	
	private function setSize(){
		 $this->size = array(imagex($this->image),imagey($this->image))
	}
	
	private function checkExtention($img){
		if (preg_match('#jpg#i',$img["val"]) || preg_match('#jpeg#i',$img["val"])){return imagecreatefromjpeg(implode('',$img));}
		else if (preg_match('#gif#i',$img["val"])){return imagecreatefromgif(implode('',$img));}
		else if (preg_match('#png#i',$img["val"])){return imagecreatefrompng(implode('',$img));}
	}
	private function DrawFiligrane(){
		imagestring($this->image, 4, $this->position[0], $this->position[1], $this->text, $this->color);
	}
	
	public function initColorList(){
		$this->colorList = array(
			"red"    => imagecolorallocate($this->image,255,0,0), 
			"green"  => imagecolorallocate($this->image,0,255,0), 
			"blue"   => imagecolorallocate($this->image,0,0,255), 
			"purple" => imagecolorallocate($this->image,131,53,130),
			"orange" => imagecolorallocate($this->image,255,186,26),
			"black"  => imagecolorallocate($this->image,0,0,0),  
			"yellow" => imagecolorallocate($this->image,249,237,4),  
			"maroon" => imagecolorallocate($this->image,217,131,36) 
		);
	}
} 
?>