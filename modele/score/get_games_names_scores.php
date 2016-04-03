<?php 

function get_all_names_games_and_score(){

	$requestUrl = 'http://benjaminbu.town/api/scores.php?action=get_games';
	$json_data = file_get_contents($requestUrl);
	$json_data = json_decode($json_data); 

	$error = 0;
	$res = array();

			if(!empty($json_data)){

				$array_name_game['jeux'] = array();
				foreach($json_data as $mydata)
				{
				    $jeu = $mydata->name;
				    $requestUrl = 'http://benjaminbu.town/api/scores.php?action=get_all_game_scores&game='.urlencode($jeu) ;
					$reponse  = file_get_contents($requestUrl);
					$value  = json_decode($reponse);
					array_push($array_name_game['jeux'], $value);
				}  

				array_push($res, $array_name_game);			
			}
			else{
				$error = 4;
			}

	$error_obj = array("error" => $error);
	array_push($res,$error_obj);

	return json_encode($res, JSON_PRETTY_PRINT);
}

