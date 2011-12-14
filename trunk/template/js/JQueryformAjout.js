$(function(){
	// au click sur le point d'interrogation, affichage du panel d'aide correspondant
	$('img#help').bind('click',function(){
		$('.showed').css('display','none');
		$('.showed').removeClass('showed');
		$('div#'+$(this).attr('class')).css('display','block');
		$('div#'+$(this).attr('class')).addClass('showed');	
	});
	
	// à la sortie du champ Taille X du formulaire de génération, test si type == SpaceInvader, et donc calcule la taille en fonction du ration 11:8
	$('input#taille_x').bind('blur',function(){
		if ($('select#type option:selected').val() == "SpaceInvader"){
			var x = parseInt(this.val()/11)* 11;
			var y = parseInt(this.val()/11)* 8;
			$('input#taille_y').val(y);
		}
	});
	
	$('input#submit').bind('click',function(){
		var Tx = $('#taille_x').val();
		var Ty = $('#taille_y').val();
		var Px = $('#pixel_x').val();
		var Py = $('#pixel_y').val();
		var Cp = $('#color_p').val();
		var Cs = $('#color_s').val();
		var T = $('select#type option:selected').val();
		var F = $('#filter').val() == 'checked' ? $('#filter').val() : "";
		
		$.getJSON('drawAvatar.php',{
			"taille_x" : Tx == "" ? null : Tx,
			"taille_y" : Ty == "" ? null : Ty,
			"pixel_x" : Px == "" ? null : Px,
			"pixel_y" : Py == "" ? null : Py,
			"color_p" : Cp == "" ? null : Cp,
			"color_s" : Cs == "" ? null : Cs,
			"type" : T,
			"filter" : F == "" ? null : F
			},function success(data){
				if(data != null){
					$('div#image_bloc').html('<img src="'+data.url+'"/>');
					$('input#hashcode_avatar').val(data.hash);
				}else{
					$('div#image_bloc').html('<span style="colod:red;">Erreur G&eacute;n&eacute;ration Avatar</span>');
				}
			},function error(data){
				alert(data);
			}
		);	
	});
});