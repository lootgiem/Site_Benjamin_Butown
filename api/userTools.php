<?php
include("./data.php");

if(isset($_GET['action'])){
		
	//$user = $bdd->quote($_GET['user']);
	$user = $_GET['user'];
	//$password = $bdd->quote($_GET['password']);
	$password = $_GET['password'];
	$mail = $_GET['mail'];
	$snapchat = $_GET['snapchat'];
	$search = $_GET['search'];
	$sid = $_GET['sid'];

	$action = $_GET['action'];

	$format = $_GET['formated'];

	if($format == "true"){
		switch($action){
			
			case "create":
				?><pre><?php echo new_user($user,$mail,$password,$snapchat,$bdd);?></pre><?php
			break;
			case "connect":
				?><pre><?php echo connect($user,$password,$bdd);?></pre><?php
			break;
			case "disconnect":
				?><pre><?php echo disconnect($user,$bdd);?></pre><?php
			break;
			case "getUserWithSid":
				?><pre><?php echo getUserWithSid($sid,$bdd);?></pre><?php
			break;
			case "getSnapchatWithUser":
				?><pre><?php echo getSnapchatWithUser($user,$bdd);?></pre><?php
			break;
			case "getUserWithSnapchat":
				?><pre><?php echo getUserWithSnapchat($snapchat,$bdd);?></pre><?php
			break;
			case "getUserWithSnapSearch":
				?><pre><?php echo getUserWithSnapSearch($search,$bdd);?></pre><?php
			break;
			case "getMailWithUser":
				?><pre><?php echo getMailWithUser($user,$bdd);?></pre><?php
			break;
			case "updateSnapchat":
				?><pre><?php echo updateSnapchat($user,$sid,$snapchat,$bdd);?></pre><?php
			break;
			case "updateRecupWithMail":
			?><pre><?php echo updateRecupWithMail($mail,$bdd);?></pre><?php
			break;
		}
	}
	else{	
		switch($action){
			
			case "create":
				echo new_user($user,$mail,$password,$snapchat,$bdd);
			break;
			case "connect":
				echo connect($user,$password,$bdd);
			break;
			case "disconnect":
				echo disconnect($user,$bdd);
			break;
			case "getUserWithSid":
				echo getUserWithSid($sid,$bdd);
			break;
			case "getSnapchatWithUser":
				echo getSnapchatWithUser($user,$bdd);
			break;
			case "getUserWithSnapchat":
				echo getUserWithSnapchat($snapchat,$bdd);
			break;
			case "getUserWithSnapSearch":
				echo getUserWithSnapSearch($search,$bdd);
			break;
			case "getMailWithUser":
				echo getMailWithUser($user,$bdd);
			break;
			case "updateSnapchat":
				echo updateSnapchat($user,$sid,$snapchat,$bdd);
			break;
			case "getLevelWithSid":
				echo getLevelWithSid($sid,$bdd);
			break;
			case "updateRecupWithMail":
				echo updateRecupWithMail($mail,$bdd);
			break;
		}
	}
}
/*Fonction New user
//Entrées : user, mail, password
//Résultat : création d'un nouvel user 
//Error : 0 : user créé
		  1 : pseudo déjà utilisé
		  2 : mail déjà utilisé
		  3 : mauvaise syntaxe email
		  4 : champs vide
		 11 : snapchat déjà utilisé
		 12 : mauvaise syntaxe pseudo : juste lettres et -
*/
function new_user($user,$mail,$password,$snapchat,$bdd){
	
	$error = 0;
	if(empty($snapchat) OR !isset($snapchat)){
		$snapchat = "";
	}
	if(!empty($user)&&!empty($mail)&&!empty($password)){
		
		if(preg_match("#^([a-zA-Z-]){0,24}$#",$user)){

			if(preg_match('#^[a-zA-Z-]+[\.]?[a-zA-Z-]+@(edu.)?esiee.fr$#',$mail)){
				//check mail esiee, check si existe
				$check_mail = $bdd->prepare('SELECT mail FROM users WHERE mail= ?');
				$check_mail->execute(array($mail));
				
				$donnees_mail = $check_mail->fetchAll( PDO::FETCH_ASSOC );
				
				if(empty($donnees_mail[0]['mail'])){
								
					//check si pseudo existe
					$check_pseudo = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo= ?');
					$check_pseudo->execute(array($user));
					
					$donnees_pseudo = $check_pseudo->fetchAll( PDO::FETCH_ASSOC );
				
					if(empty($donnees_pseudo[0]['pseudo'])){
						
						$check_snapchat = $bdd->prepare('SELECT snapchat FROM users WHERE snapchat= ?');
						$check_snapchat->execute(array($snapchat));
					
						$donnees_snapchat = $check_snapchat->fetchAll( PDO::FETCH_ASSOC );
						
						if(empty($donnees_snapchat[0]['snapchat'])){
						
							$password = sha1($password);
							$select_user = $bdd->prepare('INSERT INTO users (pseudo,mail,mdp,snapchat) VALUES (?,?,?,?)');
						
							$select_user->execute(array($user,$mail,$password,$snapchat));
						}
						else{
							$error = 11;
						}
					}
					else{
						$error = 1;
					}
				}
				else{
					$error = 2;
				}
			}
			else{
				$error = 3;
			}
		}
		else{
			$error = 12;
		}
	}
	else{
		$error = 4;
	}
	
	$res = array("error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction Connect :
//Entrées : user, password
//Résultat : Connexion d'un user
//Error : 0 : user connecté
		  4 : champs vide
		  5 : utilisateur inconnu ou identifiants incorrects
*/
function connect($user,$password,$bdd){
	
	if(!empty($user)&&!empty($password)){
		
		$password = sha1($password);
		
		$select_user = $bdd->prepare('SELECT id FROM users WHERE pseudo= ? AND mdp= ?');
		$select_user->execute(array($user,$password));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		$token = "";
		$error = 0;
		
		if(!empty($donnees)){
			
			$token = md5(md5(time()).rand());
			
			$add_token = $bdd->prepare('UPDATE users SET sessionId = ? WHERE id = ?');
			$add_token->execute(array($token,$donnees[0]['id']));
			
			//$token = json_encode($token);
			//return $token;
			
		}
		else{
			$error = 5; //login ou password inconnu
		}
	}
	else{
		$error = 4;
	}
	$res = array("token" => $token, "error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction Disconnect :
//Entrées : user
//Résultat : Déconnexion de l'user
//Error : 0 : user déconnecté
		  4 : champs vide
		  6 : sid invalide
		  7 : utilisateur déjà déconnecté
*/
function disconnect($user,$bdd){
	
	$error = 0;
	
	if(!empty($user)){
		
		$select_user = $bdd->prepare('SELECT * FROM users WHERE pseudo= ?');
		$select_user->execute(array($user));
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		
		if($donnees[0]['sessionId'] != ""){
			if($donnees[0]['pseudo'] == $user){
				$del_token = $bdd->prepare('UPDATE users SET sessionId = ? WHERE pseudo = ?');
				$del_token->execute(array("",$user));
			}
			else{
				$error = 6;
			}
		}
		else{
			$error = 7;
		}
	}
	else{
		$error = 4;
	}
	$res = array("error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction getUserWithSid :
//Entrées : sid
//Résultat : Récupération du pseudo selon token
//Error : 0 : récupération réussi
		  4 : champs vide
		  9 : utilisateur non connecté
*/
function getUserWithSid($sid,$bdd){
	
	if(!empty($sid)){
		
		$select_user = $bdd->prepare('SELECT pseudo FROM users WHERE sessionId= ?');
		$select_user->execute(array($sid));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		$pseudo = "";
		$error = 0;
		
		if(!empty($donnees)){
			$pseudo = $donnees[0]['pseudo'];
		}
		else{
			$error = 9; //utilisateur non connecté
		}
	}
	else{
		$error = 4;
	}
	$res = array("pseudo" => $pseudo, "error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction getSnapchatWithUser :
//Entrées : user
//Résultat : Récupération du pseudo snapchat selon user
//Error : 0 : récupération réussi
		  4 : champs vide
		  5 : utilisateur inconnu
*/
function getSnapchatWithUser($user,$bdd){
	
	if(!empty($user)){
		
		$select_user = $bdd->prepare('SELECT snapchat FROM users WHERE pseudo= ?');
		$select_user->execute(array($user));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		$pseudo = "";
		$error = 0;
		
		if(!empty($donnees)){
			$pseudo = $donnees[0]['snapchat'];
		}
		else{
			$error = 5; //utilisateur inconnu
		}
	}
	else{
		$error = 4;
	}
	$res = array("snapchat" => $pseudo, "error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction getUserWithSnapchat :
//Entrées : snapchat
//Résultat : Récupération du pseudo snapchat selon user
//Error : 0 : récupération réussi
		  4 : champs vide
		  5 : utilisateur inconnu
*/
function getUserWithSnapchat($snapchat,$bdd){
	
	if(!empty($snapchat)){
		
		$select_user = $bdd->prepare('SELECT * FROM users WHERE snapchat= ?');
		$select_user->execute(array($snapchat));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		$pseudo = "";
		$error = 0;
		
		if(!empty($donnees)){
			$pseudo = $donnees[0]['pseudo'];
		}
		else{
			$error = 5; //utilisateur inconnu
		}
	}
	else{
		$error = 4; //Champs vide
	}
	$res = array("pseudo" => $pseudo, "error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction getUserWithSnapSearch :
//Entrées : Search
//Résultat : Récupération du pseudo snapchat et son score selon la recherche ($search)  
//Error : 0 : récupération réussi
		  4 : champs vide
		  5 : utilisateur inconnu
*/
function getUserWithSnapSearch($search,$bdd){
	
	if(!empty($search)){
		
		$get_user_id = $bdd->prepare('SELECT * FROM users WHERE snapchat LIKE ?'); /*WHERE snapchat LIKE \'%?%\'*/
		$get_user_id->execute(array('%'.$search.'%'));
		$user_id = $get_user_id->fetchAll( PDO::FETCH_ASSOC );
		$error = 0;
		$res = array();
		$snap_search= array();
		
		if(!empty($user_id)){

			for($i = 0; $i < count($user_id); $i++) {
				$get_user_score = $bdd->prepare('SELECT * FROM games_scores WHERE id_user= ? AND id_game = 2'); //2 correspond au jeu snapchat
				$get_user_score->execute(array($user_id[$i]['id']));
				$user_scores = $get_user_score->fetchAll( PDO::FETCH_ASSOC );
				
				$value = array($user_id[$i]['snapchat'] => $user_scores[0]['score']);
				array_push($snap_search, $value);
			}
		}
		else{
			$error = 5; //Snapchat inconnu
		}
	}
	else{
		$error = 4; //Champs vide
	}
	
	$error_obj = array("error" => $error);
	array_push($res,$error_obj);
	array_push($res, $snap_search);	
	
	return json_encode($res, JSON_PRETTY_PRINT);
}


/*Fonction getMailWithUser :
//Entrées : user
//Résultat : Récupération du mail selon user
//Error : 0 : récupération réussi
		  4 : champs vide
		  5 : utilisateur inconnu
*/
function getMailWithUser($user,$bdd){
	
	if(!empty($user)){
		
		$select_user = $bdd->prepare('SELECT mail FROM users WHERE pseudo= ?');
		$select_user->execute(array($user));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		$pseudo = "";
		$error = 0;
		
		if(!empty($donnees)){
			$pseudo = $donnees[0]['mail'];
		}
		else{
			$error = 5; //utilisateur inconnu
		}
	}
	else{
		$error = 4;
	}
	$res = array("mail" => $pseudo, "error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}


/*Fonction update snapchat with pseudo and sid  :
//Entrées : user, sid, snapchat
//Résultat : change le snapchat de l'utilisateur
//Error : 0 : user connecté
		  4 : champs vide
		  5 : utilisateur inconnu ou identifiants incorrects
		  9 : Utilisateur non connecté
		 11 : Snapchat déjà utilisé
*/
function updateSnapchat($user,$sid,$snapchat,$bdd){
	
	$user_scores = "";
	$res = array();
	
	if(!empty($user) && !empty($sid) && !empty($snapchat)){
		
		$get_user_id = $bdd->prepare('SELECT * FROM users WHERE pseudo= ?');
		$get_user_id->execute(array($user));
		$user_id = $get_user_id->fetchAll( PDO::FETCH_ASSOC );
		
		$error = 0;
		
		if(!empty($user_id)){
			if($user_id[0]['sessionId'] == $sid){		
						
					$check_snapchat = $bdd->prepare('SELECT snapchat FROM users WHERE snapchat= ?');
					$check_snapchat->execute(array($snapchat));		
					$donnees_snapchat = $check_snapchat->fetchAll( PDO::FETCH_ASSOC );
						
						if(empty($donnees_snapchat[0]['snapchat'])){
							$update_score = $bdd->prepare('UPDATE users SET snapchat = ? WHERE pseudo = ? AND sessionId = ?');
							$update_score->execute(array($snapchat, $user,$sid));		
						}
						else{
							$error = 11;
						}
			}
			else{
				$error = 9;
			}
		}
		else{
			$error = 5;
		}
	}
	else{
		$error = 4;
	}

	$error_obj = array("error" => $error);
	array_push($res,$error_obj);
	
	return json_encode($res, JSON_PRETTY_PRINT);
}

/*Fonction getLevelWithSid :
//Entrées : sid
//Résultat : Récupération du pseudo selon token
//Error : 0 : récupération réussi
		  4 : champs vide
*/
function getLevelWithSid($sid,$bdd){
	
	if(!empty($sid)){
		
		$select_user = $bdd->prepare('SELECT level FROM users WHERE sessionId= ?');
		$select_user->execute(array($sid));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );
		$pseudo = "";
		$error = 0;
		
		if(!empty($donnees)){
			$pseudo = $donnees[0]['level'];
		}
		else{
			$error = 9; //utilisateur non connecté
		}
	}
	else{
		$error = 4;
	}
	$res = array("pseudo" => $pseudo, "error" => $error);
	//return json_encode($res, JSON_PRETTY_PRINT);
	return $pseudo;
}



/*Fonction updateRecupWithMail :
//Entrées : mail
//Résultat : Récupération du recup selon le mail
//Error : 0 : récupération réussi
		  5 : login ou password inconnu
*/
function updateRecupWithMail($mail,$bdd){

	if(!empty($mail)){
			
		$select_user = $bdd->prepare('SELECT id FROM users WHERE mail= ?');
		$select_user->execute(array($mail));
		
		$donnees = $select_user->fetchAll( PDO::FETCH_ASSOC );

		$recup = "";
		$error = 0;
		
		if(!empty($donnees)){
			
			$token = md5(md5(time()).rand());
			
			$add_recup = $bdd->prepare('UPDATE users SET tokenPass = ?, tokenValidity = 1 WHERE id = ?');
			$add_recup->execute(array($token,$donnees[0]['id']));
			
			$url = "http://benjaminbu.town/index.php?page=reset_pass&mail=" . $mail . "&token=" . $token;
			
			if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
			{
				$passage_ligne = "\r\n";
			}
			else
			{
				$passage_ligne = "\n";
			}
			//=====Déclaration des messages au format texte et au format HTML.
			
			//==========

			// Send mail
			//=====Création de la boundary
			$boundary = "-----=".md5(rand());
			//==========
			$bim="Pour reinitialiser ton mot de passe, clique sur le lien suivant : " . $passage_ligne . $url;
			$modif="Tu pourras ensuite te reconnecter";
			 $sign="Benjamin Butown";
			 $fb="http://www.facebook.com/benjamin.butown";
			 //$desol="Désolé pour ceux qui le reçoivent pour la deuxième fois.";
			//=====Définition du sujet.
			$sujet = "Mot de passe Benjamin Butown";
			//=========
			 
			//=====Création du header de l'e-mail.
			$header = "From: \"Benjamin Butown\"<contact@benjaminbu.town>".$passage_ligne;
			$header.= "Reply-to: \"Benjamin Butown\" <contact@benjaminbu.town>".$passage_ligne;
			$header.= "MIME-Version: 1.0".$passage_ligne;
			$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
			//==========
			 
			//=====Création du message.
			$message = $passage_ligne."--".$boundary.$passage_ligne;
			//=====Ajout du message au format texte.
			$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$bim.$passage_ligne.$modif.$passage_ligne.$passage_ligne.$sign.$passage_ligne.$fb;
			//==========
			
			//==========
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			//==========
			 
			//=====Envoi de l'e-mail.
			mail($mail,$sujet,$message,$header);
						
			//$token = json_encode($recup);
			//return $recup;	
		}
		else{
			$error = 5; //login ou password inconnu
		}
	}
	else{
		$error = 4;
	}
	//$res = array("recup" => $recup, "error" => $error);
	$res = array("error" => $error);
	return json_encode($res, JSON_PRETTY_PRINT);
}

?>