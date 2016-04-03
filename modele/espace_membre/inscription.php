<?php 
function inscription(){

    $message = "";
    $reussi = "false";
    
    if(isset($_POST['user'], $_POST['password'], $_POST['snapchat'], $_POST['passverif'], $_POST['mail']) and $_POST['user'] != '' ){

            if($_POST['password']==$_POST['passverif'])
            {
            
                if(strlen($_POST['password'])>=6)
                {
                    
                        $user = urlencode(htmlentities($_POST['user'], ENT_QUOTES, "UTF-8"));

                        $password = sha1(htmlentities($_POST['password'], ENT_QUOTES, "UTF-8"));
                        $snapchat = urlencode(htmlentities($_POST['snapchat'], ENT_QUOTES, "UTF-8"));
                        $mail = urlencode(strtolower(htmlentities($_POST['mail'], ENT_QUOTES, "UTF-8")));

                        $requestUrl = 'http://benjaminbu.town/api/userTools.php?action=create&user='.$user.'&password='.$password.'&mail='.$mail.'&snapchat='.$snapchat;
                        
                        $reponse  = file_get_contents($requestUrl);
                        $json_obj  = json_decode($reponse);
                        $error = $json_obj->error;
                       
                        if($error == 0){
                           $reussi = "true";
                        }
                        else{
                            $reussi = "false";
                            $message = return_message($error);
                        }  
                }
                else
                {
                    $reussi = "false";
                    $message = return_message(13);
                }
               
            }
            else
            {
                $reussi = "false";
                $message = return_message(14);
            }
    }
    else
    {       
        $reussi = "false";
        $message = return_message(4);

    }

$var = array( "reussi" , "message" );
$res = compact($var);
return $res;
}