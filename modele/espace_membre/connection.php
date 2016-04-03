<?php
function connection_site(){
	$token ='';
	$message ='';
	$reussi ='false';

	if( isset($_POST['user'], $_POST['password']) && !empty($_POST['user']) && !empty($_POST['password']) ){

        
            $user = urlencode(htmlentities($_POST['user'], ENT_QUOTES, "UTF-8"));
            $password = sha1($_POST['password']);
	        
            $requestUrl = 'http://benjaminbu.town/api/userTools.php?action=connect&user='.$user.'&password='.$password;                    
            $response  = file_get_contents($requestUrl);
            $json_obj  = json_decode($response);
            $error = $json_obj->error;

      		if($error == 0){ 
      			$reussi= "true";
				$message = return_message(15);
				$token = $json_obj->token;
       		} 
       		else{
				$reussi = "false";
				$message = return_message(5);
       		}       
	}
	else
	{
	    $reussi = "false";
	    $message = return_message(4);
	}


$var = array( 'reussi' , 'message' , 'token');
$res = compact($var);
return $res;
}


