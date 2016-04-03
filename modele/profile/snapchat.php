<?php
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");


function get_snapchat_account(){

	$nom_compte_snap = '';

	$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=getSnapchatWithUser&user='.urlencode($_SESSION['user']);                    
    $response  = file_get_contents($requestUrl);
    $json_obj  = json_decode($response);
    $error = $json_obj->error;
    
	if($json_obj->error == '0'){
		$nom_compte_snap = $json_obj->snapchat;
	}

return $nom_compte_snap;
}