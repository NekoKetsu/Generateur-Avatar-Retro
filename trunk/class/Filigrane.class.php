<?php

			
class Filigrane{
	
	private $image;
	private $colorLabelList = array("red","green","blue","purple","orange","black","yellow","maroon");
	
	private $size;
	private $text;
	private $textSize;
	private $position;
	private $opacity;
	private $couleur;
	
	
	public function __construct($image_link,$position,$couleur,$text,$opacity = 100){
		textSize($text[1]);
		Position($position);
		
		Text($text[0]);
		Opacity($opacity);
		
		$this->image = checkExtention($image_link);
		setSize();
		initColorList();
		Couleur($couleur);
		
		DrawFiligrane();
	}
	
	public function Text($text = null){ if($text != null){$this->text = $text; }else{ return $this->text;}}
	public function textSize($textSize = null){ if($textSize != null){$this->textSize = $textSize; }else{ return $this->textSize;}}
	public function Position($position = null){ if($position != null){$this->position = $position; }else{ return $this->position;}}
	public function Couleur($couleur = null){ if($couleur != null){$this->couleur = $this->colorList[$couleur]; }else{ return $this->couleur;}}
	public function Opacity($opacity = null){ if($opacity != null){$this->opacity = $opacity; }else{ return $this->opacity;}}
	
	private function setSize(){
		 $this->size = array(imagex($this->image),imagey($this->image))
	}
	
	private function checkExtention($image_link){
		if (preg_match('#jpg#i',$image_link) || preg_match('#jpeg#i',$image_link)){return imagecreatefromjpeg($image_link);}
		if (preg_match('#gif#i',$image_link)){return imagecreatefromgif($image_link);}
		if (preg_match('#png#i',$image_link)){return imagecreatefrompng($image_link);}
	}
	private function DrawFiligrane(){
		imagestring($this->image, 4, $this->position[0], $this->position[1], $this->text, $this-couleur);
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