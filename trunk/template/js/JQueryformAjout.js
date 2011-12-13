$(function(){

	// au click sur le point d'interrogation, affichage du panel d'aide correspondant
	$('img#help').bind('click',function(){
		$('.showed').css('display','none');
		$('.showed').removeClass('showed');
		$('div.'+this.attr('class')).css('display','block');
		$('div.'+this.attr('class')).addClass('showed');	
	});
	
	// à la sortie du champ Taille X du formulaire de génération, test si type == SpaceInvader, et donc calcule la taille en fonction du ration 11:8
	$('input#taille_x').bind('blur',function(){
		if ($('select#type option:selected').val() == "SpaceInvader"){
			var x = parseInt(this.val()/11)* 11;
			var y = parseInt(this.val()/11)* 8;
			$('input#taille_y').val(y);
		}
	});
});