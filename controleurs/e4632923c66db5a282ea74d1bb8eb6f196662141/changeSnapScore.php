<?php

include_once('../../modele/message.php');

$snapchat = htmlentities($_GET['snapchat']);
$add = htmlentities($_GET['add']);
$score = htmlentities($_GET['score_actuel']);
$search = htmlentities($_GET['search']);
$message ='';

if(isset($add,$snapchat,$score) && !empty($add) && !empty($snapchat) && (!empty($score) || $score == 0 )){

	$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=getUserWithSnapchat&snapchat='.urlencode($snapchat);                    
    $response  = file_get_contents($requestUrl);
    $json_obj  = json_decode($response);
    $error = $json_obj->error;

	if($error == 0){
		$user = urlencode($json_obj->pseudo);


			$score_final = $score + $add;
			$requestUrl = 'http://benjaminbu.town/controleurs/e4632923c66db5a282ea74d1bb8eb6f196662141/addSnapScore.php?action=add_user_score&user='.$user.'&game=Snapchat&score='.$score_final;  
			$response  = file_get_contents($requestUrl);
				  
		    $json_obj  = json_decode($response);
		    $error = $json_obj->error;

		    if( $error == 0 ){	
		    	$message = "Score mis a jour pour l'utilisateur : ".$user." qui possède le snap : ".$snapchat." ---> Score Final :".$score_final;
				header('location:admin.php?search='.urlencode($search).'&m_p='.urlencode($message));
				exit();
		    }
		    else{
		    	$message = "Erreur inconnue : L'update du score n'a pas pu se faire";
		    }

	}
	else{
		$message = return_message(5);
	}
}
else{
	$message = return_message(4);
}

header('location:admin.php?search=<?php echo $_GET["search"];?>&m_n='.urlencode($message));
exit();