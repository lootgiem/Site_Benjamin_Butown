<?php 

	function envoi_mail($mail){
		$message ='';
		$user = htmlentities($user);

		$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=updateRecupWithMail&mail='.urlencode($mail);                    
	    $response  = file_get_contents($requestUrl);
	    $json_obj  = json_decode($response);
	    $error = $json_obj->error;
	    
	    return $error;
	}