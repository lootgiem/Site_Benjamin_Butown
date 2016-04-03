<?php
include("../../api/data.php");

if(isset($_GET['action'])){

	$user = $_GET['user'];
	$sid = $_GET['sid'];
	$game = $_GET['game'];
	$score = $_GET['score'];

	$action = $_GET['action'];
	$format = $_GET['formated'];

	if($format == "true"){
		switch($action){
			case "add_user_score":
				?><pre><?php echo add_user_score($user,$game,$score,$bdd);?></pre><?php
			break;
		}
	}
	else{
		switch($action){
			case "add_user_score":
				echo add_user_score($user,$game,$score,$bdd);
			break;
		}
	}
}

/*Fonction Add user Score for user :
//Entrées : user, game, score
//Résultat : tableau des scores pour les jeux
//Error : 0 : user connecté
		  4 : champs vide
		  5 : utilisateur inconnu ou identifiants incorrects
		  8 : Pas de score pour l'utilisateur
*/
function add_user_score($user,$game,$score,$bdd){
	
	$user_scores = "";
	$res = array();
	
	if(!empty($user) && !empty($game) && !empty(score)){
		
		$get_user_id = $bdd->prepare('SELECT * FROM users WHERE pseudo= ?');
		$get_user_id->execute(array($user));
		$user_id = $get_user_id->fetchAll( PDO::FETCH_ASSOC );
		
		$error = 0;
		
		if(!empty($user_id)){

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

?>