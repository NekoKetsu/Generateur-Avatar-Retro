$(function(){

	// au click sur le point d'interrogation, affichage du panel d'aide correspondant
	$('img.help').bind('click',function(){
		$('.showed').css('display','none');
		$('.showed').removeClass('showed');
		var clas = $(this).attr('class').split(" ");
		$('div#'+clas[1]).css('display','block');
		$('div#'+clas[1]).addClass('showed');	
	});
	
	$('input.button').bind('click',function(){
		var D = $('input#dir').val();
		var Tx = $('input#text').val();
		var Ts = $('input#text_size').val();
		var C = $('select#color option:selected').val();
		var P = $('select#position option:selected').val();
		var O = $('input#opacity').val();
		var T = $(this).attr('id');

		$.getJSON('drawFiligrane.php',{
			"filimgdir" : D,
			"filimgtext" : Tx,
			"filimgcolor" : C,
			"filimgposition" : P,
			"filimgopacity" : O,
			"filimgtextsize" : Ts,
			"type" : T
			},function success(data){
				if(data != null){
					if (T == "save_button"){
						alert("Sauvegarde Effectuée");
					}else if (T == "preview_button"){
						$('div#image_bloc').html('<img src="'+data.url+'"/>');
						$('input#hashcode_avatar').val(data.hash);
					}
					
				}else{
					$('div#image_bloc').html('<span style="colod:red;">Erreur G&eacute;n&eacute;ration Avatar</span>');
				}
			},function error(data){
				alert(data);
			}
		);	
	});
});
	
	
	
	