$(function(){
	// au click sur le point d'interrogation, affichage du panel d'aide correspondant
	$('img.help').bind('click',function(){
		$('.showed').css('display','none');
		$('.showed').removeClass('showed');
		var clas = $(this).attr('class').split(" ");
		$('div#'+clas[1]).css('display','block');
		$('div#'+clas[1]).addClass('showed');	
	});
	
	// à la sortie du champ Taille X du formulaire de génération, test si type == SpaceInvader, et donc calcule la taille en fonction du ration 11:8
	$('input#taille_x').bind('blur',function(){
		setAvatarDimension();
	});
	
	$('select#color_p').bind('change',function(){
		var checked = $('select#color_s option:selected').attr('class');
		reloadColor('s');
		$('select#color_s option.color_'+$(this).val()).remove();
		$('select#color_s option.'+checked).attr('selected','selected');
	});
	$('select#color_s').bind('change',function(){
		var checked = $('select#color_p option:selected').attr('class');
		reloadColor('p');
		$('select#color_p option.color_'+$(this).val()).remove();
		$('select#color_p option.'+checked).attr('selected','selected');
	});
	
	$('select#type').bind('change',function(){
		if ($('select#type option:selected').val() == "SpaceInvader"){
			$('input#pixel_x').attr('readonly','readonly');
			$('input#pixel_y').attr('readonly','readonly');
			$('input#pixel_x').css('background-color','grey');
			$('input#pixel_y').css('background-color','grey');
		}else{
			$('input#pixel_x').removeAttr('readonly');
			$('input#pixel_y').removeAttr('readonly');
			$('input#pixel_x').css('background-color','#fff');
			$('input#pixel_y').css('background-color','#fff');
		}
		setAvatarDimension();
	});
	
	$('input#submit_button').bind('click',function(){
		var Tx = $('input#taille_x').val();
		var Ty = $('input#taille_y').val();
		var Px = $('input#pixel_x').val();
		var Py = $('input#pixel_y').val();
		var Cp = $('select#color_p option:selected').val();
		var Cs = $('select#color_s option:selected').val();
		var T = $('select#type option:selected').val();
		var F = $('input#degrade').attr('checked') == 'checked' ? 'degrade' : "";// == 'checked' ? $('#filter').val() : "";
		
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
	function setAvatarDimension(){
		if ($('select#type option:selected').val() == "SpaceInvader"){
			var x = parseInt($('input#taille_x').val()/11)* 11;
			var y = parseInt($('input#taille_x').val()/11)* 8;
			$('input#taille_x').val(x);
			$('input#taille_y').val(y);
		}else{
			$('input#taille_x').val('300');
			$('input#taille_y').val('300');
		}
		setPixelDimension();
	}
	
	function setPixelDimension(){
		if ($('select#type option:selected').val() == "SpaceInvader"){
			$('input#pixel_x').val($('input#taille_x').val()/11);
			$('input#pixel_y').val($('input#taille_y').val()/8);
		}else{
			$('input#pixel_x').val('30');
			$('input#pixel_y').val('30');
		}
	}
	function reloadColor(a){
		$('select#color_'+a).remove('option');
		$('select#color_'+a).html('<option value=""></option><option class="color_0" value="0">Rouge</option><option class="color_1" value="1">Vert</option> <option class="color_2" value="2">Bleu</option><option class="color_3" value="3">Violet</option><option class="color_4" value="4">Orange</option><option class="color_5" value="5">Noir</option><option class="color_6" value="6">Jaune</option><option class="color_7" value="7">Marron</option>');
	}
});
	
	
	
	