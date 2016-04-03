<?php
function update_Snapchat(){

	$message ='';
	$reussi ='false';

 	$snapchat = urlencode(htmlentities($_POST['snapchat'], ENT_QUOTES, "UTF-8"));
 	$user = urlencode($_SESSION['user']);
 	$sid = urlencode($_SESSION['token']);

	$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=updateSnapchat&user='.$user.'&sid='.$sid.'&snapchat='.$snapchat;
    $response  = file_get_contents($requestUrl);
    $json_obj  = json_decode($response);
    $error = $json_obj[0]->error;
    switch ($error){
	    case 0:
	    	$reussi = "true";
	   		$message = return_message(17);
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
