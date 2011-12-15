<?php

			
class Filigrane{

	private $image;
	private $colorLabelList = array("red","green","blue","purple","orange","black","yellow","maroon");
	private $positionList = array("Haut-Droite" => '' ,"Haut-Gauche" => array(5,5),"Bas-Droite","Bas-Gauche" => array(5,5),"Centré-Bas","Centré-Haut","Centré-Milieu");
	
	private $size;
	private $text;
	private $textSize;
	private $position_x;
	private $position_y;
	private $opacity;
	private $color;
	private $colorList;
	
	
	public function __construct($img,$position,$text,$color,$opacity){
		$this->textSize($text["size"]);
		$this->Text($text["val"]);
		$this->Opacity($opacity);
		
		$this->image = $this->checkExtention($img);
		
		$this->initColorList();
		$this->Color($color);
		$this->setSize();
		$this->Position($position);
		$this->DrawFiligrane();
	}
	public function Image($img = null){ if($img != null){$this->image = $img; }else{ return $this->image;}}
	public function Text($text = null){ if($text != null){$this->text = $text; }else{ return $this->text;}}
	public function textSize($textSize = null){ if($textSize != null){$this->textSize = $textSize; }else{ return $this->textSize;}}
	public function Position($pos = null){ 
		if($pos != null){
			 $this->setPosition($pos);
		}
	}
	public function Color($color = null){ if($color != null){$this->color = $color; }else{ return $this->color;}}
	public function Opacity($opacity = null){ if($opacity != null){
		$this->opacity = $opacity; 
		}else{ return $this->opacity;}}
	
	private function setSize(){
		 $this->size = array(imagesx($this->image),imagesy($this->image));
	}
	
	private function checkExtention($img){
		if (preg_match('#jpg#i',$img) || preg_match('#jpeg#i',$img)){return imagecreatefromjpeg($img);}
		else if (preg_match('#gif#i',$img)){return imagecreatefromgif($img);}
		else if (preg_match('#png#i',$img)){return imagecreatefrompng($img);}
	}
	private function DrawFiligrane(){
		imagestring($this->image,4,$this->position_x, $this->position_y, $this->text, $this->colorList[$this->color]);
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
	
	private function setPosition($pos){
		switch ($pos){ 
			case 0:
				$this->position_x = $this->size[0] - ((imagefontwidth(4)*strlen($this->text))+5);
				$this->position_y = 5;
				break;
			
			case 1:
				$this->position_x = 5;
				$this->position_y = 5;
				break;
			
			case 2:
				$this->position_x = $this->size[0] - ((imagefontwidth(4)*strlen($this->text))+5);
				$this->position_y = $this->size[1] - (imagefontheight(4)+5);
				break;
			
			case 3:
				$this->position_x = 5;
				$this->position_y = $this->size[1] - (imagefontheight(4)+5);
				break;
			
			case 4:
				$this->position_x = $this->size[0]/2 - (imagefontwidth(4)/2*strlen($this->text));
				$this->position_y = $this->size[1] -   (imagefontheight(4)+5);
				break;
			
			case 5:
				$this->position_x = $this->size[0]/2 - (imagefontwidth(4)/2*strlen($this->text));
				$this->position_y = 5;
				break;
			
			case 6:
				$this->position_x = $this->size[0]/2 - (imagefontwidth(4)/2*strlen($this->text));
				$this->position_y = $this->size[1]/2 - (imagefontheight(4)/2);
				break;
			
			default:
				$this->position_x = 5;
				$this->position_y = 5;
		}
	}
} 
?>