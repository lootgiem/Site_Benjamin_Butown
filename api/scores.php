<?php
include("./data.php");

if(isset($_GET['action'])){
	$user = $_GET['user'];
	$password = $_GET['password'];
	$mail = $_GET['mail'];
	$sid = $_GET['sid'];
	$game = $_GET['game'];
	$score = $_GET['score'];

	$action = $_GET['action'];

	$format = $_GET['formated'];

	if($format == "true"){
		switch($action){
			case "get_user_all_scores":
				?><pre><?php echo get_user_all_scores($user,$bdd);?></pre><?php
			break;
			case "add_user_score":
				?><pre><?php echo add_user_score($user,$sid,$game,$score,$bdd);?></pre><?php
			break;
			case "get_all_game_scores":
				?><pre><?php echo get_all_game_scores($game,$bdd);?></pre><?php
			break;
			case "get_all_scores":
				?><pre><?php echo get_all_scores($bdd);?></pre><?php
			break;
			case "get_games":
				?><pre><?php echo get_games($bdd);?></pre><?php
			break;
		}
	}
	else{
		switch($action){
			case "get_user_all_scores":
				echo get_user_all_scores($user,$bdd);
			break;
			case "add_user_score":
				echo add_user_score($user,$sid,$game,$score,$bdd);
			break;
			case "get_all_game_scores":
				echo get_all_game_scores($game,$bdd);
			break;
			case "get_all_scores":
				echo get_all_scores($bdd);
			break;
			case "get_games":
				echo get_games($bdd);
			break;
		}
	}
}

/*Fonction Get All User Scores :
//Entrées : user
//Résultat : tableau des scores pour les jeux
//Error : 0 : user connecté
		  4 : champs vide
		  5 : utilisateur inconnu ou identifiants incorrects
		  8 : Pas de score pour l'utilisateur
*/
function get_user_all_scores($user,$bdd){
	
	$user_scores = "";
	$res = array();
	
	if(!empty($user)){
		
		$get_user_id = $bdd->prepare('SELECT id FROM users WHERE pseudo= ?');
		$get_user_id->execute(array($user));
		$user_id = $get_user_id->fetchAll( PDO::FETCH_ASSOC );
		
		$error = 0;
		
		if(!empty($user_id)){
			$score_exist = $bdd->prepare('SELECT * FROM games_scores WHERE id_user= ?');
			$score_exist->execute(array($user_id[0]['id']));
			$user_scores = $score_exist->fetchAll( PDO::FETCH_ASSOC );

			if(!empty($user_scores)){
				
				for($i = 0; $i < count($user_scores); $i++) {
					
					$get_game_name = $bdd->prepare('SELECT * FROM games WHERE id = ?');
					$get_game_name->execute(array($user_scores[$i]['id_game']));
					$game_name = $get_game_name->fetchAll( PDO::FETCH_ASSOC );
					
					$value = array($game_name[0]['name'] => $user_scores[$i]['score']);
					array_push($res, $value);
				}
			}
			else{
				$error = 8;
			}
		}
		else{
			$error = 5;
		}
	}
	else{
		$error = 4;
	}

	$error_obj = array("error" => $error);
	array_push($res,$error_obj);
	
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction Get All Game Scores :
//Entrées : user
//Résultat : tableau des scores pour les jeux
//Error : 0 : user connecté
		  4 : champs vide
		  5 : utilisateur inconnu ou identifiants incorrects
		  8 : Pas de score pour l'utilisateur
		  10: Pas de jeu à ce nom
*/
function get_all_game_scores($game,$bdd){
	
	$user_scores = "";
	$res = array();
	
	$error = 0;
	
	if(!empty($game)){
		
		$get_game_name = $bdd->prepare('SELECT * FROM games WHERE name = ?');
		$get_game_name->execute(array($game));
		$game_name = $get_game_name->fetchAll( PDO::FETCH_ASSOC );
		
		if(!empty($game_name)){
			
			$score_exist = $bdd->prepare('SELECT * FROM games_scores WHERE id_game= ? ORDER BY score DESC');
			$score_exist->execute(array($game_name[0]['id']));
			$scores = $score_exist->fetchAll( PDO::FETCH_ASSOC );
			
			$array_game[$game] = array();
			
			for($i = 0; $i < count($scores); $i++) {
				
				
				$get_user_pseudo = $bdd->prepare('SELECT * FROM users WHERE id = ? AND level<1');
				$get_user_pseudo->execute(array($scores[$i]['id_user']));
				$user_pseudo = $get_user_pseudo->fetchAll( PDO::FETCH_ASSOC );
				
				if(!empty($user_pseudo[0]['id'])){		
				$score_exist = $bdd->prepare('SELECT * FROM games_scores WHERE id_game= ? AND id_user= ?');
				$score_exist->execute(array($game_name[0]['id'], $user_pseudo[0]['id']));
				$user_scores = $score_exist->fetchAll( PDO::FETCH_ASSOC );
			
				
				$value = array($user_pseudo[0]['pseudo'] => $user_scores[0]['score']);
				array_push($array_game[$game], $value);
				}
			}
			
			array_push($res, $array_game);
		}
		else{
			$error = 10;
		}
	}
	else{
		$error = 4;
	}
	
	$error_obj = array("error" => $error);
	array_push($res,$error_obj);
	
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction Add user Score for user :
//Entrées : user, game, sid, score
//Résultat : tableau des scores pour les jeux
//Error : 0 : user connecté
		  4 : champs vide
		  5 : utilisateur inconnu ou identifiants incorrects
		  8 : Jeu inconnu
		  9 : Utilisateur non connecté
*/
function add_user_score($user,$sid,$game,$score,$bdd){
	
	$user_scores = "";
	$res = array();
	
	if(!empty($user) && !empty($sid) && !empty($game) && !empty(score)){
		
		$get_user_id = $bdd->prepare('SELECT * FROM users WHERE pseudo= ?');
		$get_user_id->execute(array($user));
		$user_id = $get_user_id->fetchAll( PDO::FETCH_ASSOC );
		
		$error = 0;
		
		if(!empty($user_id)){
			$level = file_get_contents("http://benjaminbu.town/api/userTools.php?action=getLevelWithSid&sid=".$sid."");
			
			if($user_id[0]['sessionId'] == $sid OR $level >= 2){
				$get_game_name = $bdd->prepare('SELECT * FROM games WHERE name = ?');
				$get_game_name->execute(array($game));
				$game_name = $get_game_name->fetchAll( PDO::FETCH_ASSOC );
						
				if(!empty($game_name)){
					
					$score_exist = $bdd->prepare('SELECT * FROM games_scores WHERE id_user= ? AND id_game = ?');
					$score_exist->execute(array($user_id[0]['id'],$game_name[0]['id']));
					$user_scores = $score_exist->fetchAll( PDO::FETCH_ASSOC );
					
					if(!empty($user_scores)){
						
						$update_score = $bdd->prepare('UPDATE games_scores SET score = ? WHERE id_user = ? AND id_game = ?');
						$update_score->execute(array($score, $user_id[0]['id'],$game_name[0]['id']));
					}
					else{
						$insert_score = $bdd->prepare('INSERT INTO games_scores (id_user,id_game,score) VALUES (?,?,?)');
						$insert_score->execute(array($user_id[0]['id'],$game_name[0]['id'],$score));
					}
					/////score général/////
					$score_exist_general = $bdd->prepare('SELECT * FROM games_scores WHERE id_user= ? AND id_game= 1');
					$score_exist_general->execute(array($user_id[0]['id']));
					$user_scores_general = $score_exist_general->fetchAll( PDO::FETCH_ASSOC );
					
					if(!empty($user_scores_general)){
						$score = $score+$user_scores_general[0]['score'];
						$update_score_general = $bdd->prepare('UPDATE games_scores SET score = ? WHERE id_user = ? AND id_game= 1');
						$update_score_general->execute(array($score, $user_id[0]['id']));
					}
					else{
						$insert_score_general = $bdd->prepare('INSERT INTO games_scores (id_user,id_game,score) VALUES (?,?,?)');
						$insert_score_general->execute(array($user_id[0]['id'],'1',$score));
					}
				}
				else{
					$error = 8;
				}
			}
			else{
				$error = 9;
			}
		}
		else{
			$error = 5;
		}
	}
	else{
		$error = 4;
	}

	$error_obj = array("error" => $error);
	array_push($res,$error_obj);
	
	return json_encode($res, JSON_PRETTY_PRINT);
	
	
}

/*Fonction Get Games :
//Entrées : 
//Résultat : Liste des jeux
//Error : 0 : Liste renvoyée
		  4 : champs vide
*/
function get_games($bdd){
	
	$res = array();
		
	$get_game_name = $bdd->prepare('SELECT * FROM games WHERE visible=1');
	$get_game_name->execute();
	$game_name = $get_game_name->fetchAll( PDO::FETCH_ASSOC );

		for($i = 0; $i < count($game_name); $i++) {
			
		//$array_game[$game_name[$i]['name']]	
		$array_game = array("id" => $game_name[$i]['id'], "name" => $game_name[$i]['name'], "coeff" => $game_name[$i]['coeff']);
		array_push($res, $array_game);	
		}
	
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction Get All Scores :
//Entrées : 
//Résultat : tableau des scores pour tous les jeux
//Error : 0 : tableau récupéré
*/
function get_all_scores($bdd){
	
	$user_scores = "";
	$res = array();
	$temp = array();
	$array_game = array();
	$error = 0;

	$get_game_name = $bdd->prepare('SELECT * FROM games');
	$get_game_name->execute();
	$game_name = $get_game_name->fetchAll( PDO::FETCH_ASSOC );
	
	if(!empty($game_name)){
		for($j = 0; $j < count($game_name); $j++){
			
			$score_exist = $bdd->prepare('SELECT * FROM games_scores WHERE id_game= ? ORDER BY score DESC');
			$score_exist->execute(array($game_name[$j]['id']));
			$scores = $score_exist->fetchAll( PDO::FETCH_ASSOC );
			
			$array_game[$game_name[$j]['name']] = array();
			
			for($i = 0; $i < count($scores); $i++) {
				
				
				$get_user_pseudo = $bdd->prepare('SELECT * FROM users WHERE id = ? AND level<1');
				$get_user_pseudo->execute(array($scores[$i]['id_user']));
				$user_pseudo = $get_user_pseudo->fetchAll( PDO::FETCH_ASSOC );
						
				$score_exist = $bdd->prepare('SELECT * FROM games_scores WHERE id_game= ? AND id_user= ?');
				$score_exist->execute(array($game_name[$j]['id'], $user_pseudo[0]['id']));
				$user_scores = $score_exist->fetchAll( PDO::FETCH_ASSOC );
	
				if(!empty($user_scores)){
					$value = array($user_pseudo[0]['pseudo'] => $user_scores[0]['score']);
					array_push($array_game[$game_name[$j]['name']], $value);
				}
			}
			$temp[$j] = $array_game[$game_name[$j]['name']];
			$temp[$j] = array("name" => $game_name[$j]['name'], "scores" => $temp[$j]);
		}
		
		array_push($res, $temp);
	}
	else{
		$error = 10;
	}
	
	
	
	$error_obj = array("error" => $error);
	array_push($res,$error_obj);
	
	
	return json_encode($res, JSON_PRETTY_PRINT);
}


?>