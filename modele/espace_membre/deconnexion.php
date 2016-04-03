<?php
function deconnexion_site(){

	$message ='';
	$reussi ='false';

	$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=disconnect&user='.urlencode($_SESSION['user']);                    
    $response  = file_get_contents($requestUrl);
    $json_obj  = json_decode($response);
    $error = $json_obj->error;
    
    switch ($error){
	    case 0:
	    	$reussi = "true";
	   		$message = return_message(16);
	        break;
	    default:
	  		$reussi = "false";
	  		$message = return_message($error);
	        break;
	    }

$var = array( 'reussi' , 'message');
$res = compact($var);
return $res;
}
