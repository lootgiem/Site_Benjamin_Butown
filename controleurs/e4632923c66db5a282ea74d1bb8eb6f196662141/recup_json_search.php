<?php
function search_snap(){

	$message ='';
	$reussi ='false';

	$requestUrl = 'http://benjaminbu.town/api/userTools.php?action=getUserWithSnapSearch&search='.urlencode($_GET['search']);                    
    $response  = file_get_contents($requestUrl);
    $json_obj  = json_decode($response);

return $json_obj;
}
