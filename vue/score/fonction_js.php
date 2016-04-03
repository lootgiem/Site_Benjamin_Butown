<script src="vue/jquery-2.1.4.min.js"></script>
<script type="text/javascript">

	Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
	};

	var json = <?php echo $json_game_name ?>;
	
	data = json[0].jeux;
	var i = 0;
	var tab_game = new Array();

		for(var key in data){
			data1 = data[key][0]; 															
			for(var key in data1){  														
				eval("var jeu_"+i+" = {}");													
				tab_game.push(key);															
				$("#liste").append('<option value="'+ key +'">'+key+'</option>');								
				data2 = data1[key]															
				for(var key in data2){	
					data3 = data2[key]    													
					for(var key in data3){													
							eval("jeu_" + i + "['" + key + "']=" + data3[key]);					
					}
				}
			i++;
			}
		}

	<?php if( isset($_SESSION['user'])){ ?> 						/*Si l'utilisateur est connecté*/
		
		var json_user = <?php echo $json_user_score ?>;
		var tab_score_user = {};
		var test_error = json_user[0];

		for(var key in test_error){
			var error = test_error[key];
		}
		if(error != 8){
			for(var key in json_user){
				var data = json_user[key];	
				for(var key in data){
					if (data[key] != 0 ){ tab_score_user[key] = data[key];}
				}
			}	
		}
	<?php } ?>											/*FIN*/
	
	function back_to_last_page(){
		document.location.href="index.php?page=jeux"
	}

	function efface_scores(){
		var element = document.getElementById("tab_score");
			while (element.firstChild) {
			  element.removeChild(element.firstChild);
			}
	}

	function reverse_tab(ind_tab){			
		game_tab = eval('jeu_'+ ind_tab);
		var temp_keys = new Array();
		var temp_val = new Array();
	
		for (var keys in game_tab) {
  		  temp_keys.unshift(keys);
  		  temp_val.unshift(game_tab[keys]);
		}
		eval("jeu_"+ ind_tab +" = {}");	

		for (var i =0; i < temp_keys.length;i++) {
  			eval("jeu_" + ind_tab + "['" + temp_keys[i] + "']=" + temp_val[i]);	
		}
	}

	function tab_a_afficher(ind,value,trie){  
		var tab_aff = eval('jeu_'+ ind);
		var i = 0;
		if(trie){var i = Object.size(tab_aff)-1;}
		if(trie){$("#tab_score").append('<table id="scores">'+
									'<tr>'+
										'<th class="classement">Classement</th>'+
										'<th class="game">Pseudo</th>'+
										'<th class="curseur_sur_trie" title="Trier par ordre décroissant" onclick="changer_trie('+ind+',0)">'+ tab_game[ind] +'<i class="fa fa-sort-amount-asc "></i></th>'+
									'</tr>'+
								'</table>');
		}
		else{$("#tab_score").append('<table id="scores">'+
									'<tr>'+
										'<th class="classement">Classement</th>'+
										'<th class="game">Pseudo</th>'+
										'<th class="curseur_sur_trie" title="Trier par ordre croissant" onclick="changer_trie('+ind+',1)">'+ tab_game[ind] +'<i class="fa fa-sort-amount-desc"></i></th>'+
									'</tr>'+
								'</table>');
		}
		

		<?php if( isset($_SESSION['user'])){ ?>    /*Si l'utilisateur est connecté*/
		var user_in = false;
		for(var key in tab_aff){
			if( key == <?php echo "\"".$_SESSION['user']."\""?>){
				var user_in = true;
			}
		}							

		//Si l'utilisateur à un score dans le jeu
		var get_a_score = false;
	    if(!user_in){
		    for(var key in tab_score_user){
				if( key == value){
					get_a_score = true;						
				}
			}
		}
		
		//Partie pour ajouter le score de l'utilisateur
		if(get_a_score  && !user_in){

				var score_perso='Erreur';
				var value = document.getElementById("liste").value;
				for(var keys in tab_score_user){	/*Score associé*/
					if(keys == value){
						score_perso = tab_score_user[keys]; 
					}
				}	
						/* Si l'utilisateur a un score mais qu'il n'est pas dans le top affiché on le met en haut avec sont score en non classé */
						$('#scores').append('<tr class="scoreline score_perso"><td class="rang">Non classé</td><td class="name_user"><?php echo htmlentities($_SESSION["user"], ENT_QUOTES, "UTF-8")?></td><td class="score">'+score_perso+'</td></tr>');
				}
		else if( !get_a_score && !user_in){
						/* Si l'utilisateur n'a pas de score et qu'il n'est pas dans le top affiché on le met en haut avec une croix qui indique qu'il n'a pas encore joué */
						$('#scores').append('<tr class="scoreline score_perso"><td class="rang">Non classé</td><td class="name_user"><?php echo htmlentities($_SESSION["user"], ENT_QUOTES, "UTF-8")?></td><td class="score" >Vous n\'avez pas encore joué à ce jeux !</td></tr>');
				}

		<?php } ?>											/*FIN*/


		//Partie pour ajouter les scores generaux
		for(var key in tab_aff){
			<?php if( isset($_SESSION['user']) ){ ?>  
			if ( key == <?php echo "\"".$_SESSION['user']."\""; ?> ){
				$('#scores').append('<tr class="scoreline score_perso"><td class="rang">' + (i+1) + '</td><td class="name name_user" >' + key  + ' </td><td class="score" >' + tab_aff[key] + '</td></tr>'); 
			}
			<?php 
				echo "else{";
			}
			else{
				echo "if(true){";
			} 
			?>$('#scores').append('<tr class="scoreline"><td class="rang">' + (i+1) + '</td><td class="name" >' + key  + ' </td><td class="score" >' + tab_aff[key] + '</td></tr>');
			}				
		if(trie){i--;}
		else{i++;}
		}

		//Partie pour ajouter les trophée et les couleurs correspondantes

		if(trie && Object.size(tab_aff) > 3 ){
			$('.name:gt('+(Object.size(tab_aff)-4)+')').append('<i class="fa fa-trophy"></i>');
		}
		else{
			$('.name:lt(3)').append('<i class="fa fa-trophy"></i>');
		}

		if(trie){
				if( (Object.size(tab_aff)-3) >= 0){
					$('.name:eq('+(Object.size(tab_aff)-3)+')').addClass(" podium3");
				}
				if( (Object.size(tab_aff)-2) >= 0){
					$('.name:eq('+(Object.size(tab_aff)-2)+')').addClass(" podium2");
				}
				if( (Object.size(tab_aff)-1) >= 0){
					$('.name:eq('+(Object.size(tab_aff)-1)+')').addClass(" podium1");}
				}
		else{

			 $('.name:eq(2)').addClass(" podium3");
			 $('.name:eq(1)').addClass(" podium2");
			 $('.name:eq(0)').addClass(" podium1");}
	}

	function control_aff(trie,jeu){
		var values = '';
		var i = 0;
		var ind = document.getElementById("liste").selectedIndex;
		var value = document.getElementById("liste").value;

 		if( jeu != 0){							//On regarde si le jeu dans l'url passé en parametre existe et si oui alors on affiche ca table des scores.
 			$('#liste option').each(function() {
 				if(	jeu  == $(this).val()){
 					ind = i;
 					value = $(this).val();
 					document.getElementById("liste").options[ind].selected=true;
 					return;
 					}
 				i++;
	 		});
 		}
		efface_scores();
		tab_a_afficher(ind,value,trie);
	}

	function changer_trie(ind,trie){
		reverse_tab(ind);
		control_aff(trie,""); 
	}

</script>