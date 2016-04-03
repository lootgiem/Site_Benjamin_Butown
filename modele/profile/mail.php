<?php
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");


function get_mail_account($user){

	$nom_mail_compte = '';

	$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=getMailWithUser&user='.urlencode($user);                    
    $response  = file_get_contents($requestUrl);
    $json_obj  = json_decode($response);
    $error = $json_obj->error;
    
	if($json_obj->error == '0'){
		$nom_mail_compte = $json_obj->mail;
	}

return $nom_mail_compte;
}