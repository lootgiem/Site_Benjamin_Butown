<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");

include_once('modele/score/get_games_names_scores.php');  

$json_game_name = get_all_names_games_and_score();

if(isset($_SESSION['user'])){	

	$requestUrl = 'http://benjaminbu.town/api/scores.php?action=get_user_all_scores&user='.urlencode($_SESSION['user']);
	$json_user_score = file_get_contents($requestUrl);
	
}

include_once('vue/score/score.php');  



