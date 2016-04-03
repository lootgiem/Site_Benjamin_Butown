<?php
include("./data.php");

if(isset($_GET['action'])){

  $action = $_GET['action'];

	$nom = $_GET['nom'];
	$prenom = $_GET['prenom'];
	$mail = $_GET['mail'];
  $phone = $_GET['phone'];
	$id_event = $_GET['id_event'];
  $commande = $_GET['commande'];
	$token = $_GET['token'];

  $nom2 = $_GET['nom2'];
	$prenom2 = $_GET['prenom2'];
  $mail2 = $_GET['mail2'];
  $nom3 = $_GET['nom3'];
	$prenom3 = $_GET['prenom3'];
  $mail3 = $_GET['mail3'];
  $nom4 = $_GET['nom4'];
  $prenom4 = $_GET['prenom4'];
  $mail4 = $_GET['mail4'];
  $nom5 = $_GET['nom5'];
	$prenom5 = $_GET['prenom5'];
  $mail5 = $_GET['mail5'];

	$nom_groupe = $_GET['nom_groupe'];

	$formated = $_GET['formated'];
	if($formated == "true"){
		switch($action){

      case "getVisibility":
				?><pre><?php echo getPlaces($id_event,$bdd);?></pre><?php
			break;
			case "getPlaces":
				?><pre><?php echo getPlaces($id_event,$bdd);?></pre><?php
			break;
      case "getGroupe":
				?><pre><?php echo getGroupe($nom_groupe,$bdd);?></pre><?php
			break;
      case "getReservations":
        ?><pre><?php echo getReservations($id_event,$bdd);?></pre><?php
      break;
      case "validate":
        ?><pre><?php echo validate($id_event, $nom, $prenom, $token, $bdd);?></pre><?php
      break;
      case "validateGroupe":
        ?><pre><?php echo validateGroupe($nom_groupe, $token, $bdd);?></pre><?php
      break;
      case "insertGroupeReservation":
        ?><pre><?php echo insertGroupeReservation($id_event, $nom_groupe, $nom, $prenom, $mail, $phone, $nom2, $prenom2, $mail2, $nom3, $prenom3, $mail3, $nom4, $prenom4, $mail4, $nom5, $prenom5, $mail5, $bdd);?></pre><?
      break;
      case "insertEntry":
        ?><pre><?php echo insertEntry($id_event, $nom_groupe, $nom, $prenom, $mail, $phone, $commande, $bdd);?></pre><?php
      break;
		}
	}
	else{
		switch($action){

      case "getVisibility":
				echo getVisibility($id_event,$bdd);
			break;
      case "getPlaces":
				echo getPlaces($id_event,$bdd);
			break;
      case "getGroupe":
				echo getGroupe($nom_groupe,$bdd);
			break;
      case "getReservations":
				echo getReservations($id_event,$bdd);
			break;
      case "validate":
        echo validate($id_event, $nom, $prenom, $token, $bdd);
      break;
      case "validateGroupe":
        echo validateGroupe($nom_groupe, $token, $bdd);
      break;
      case "insertGroupeReservation":
        echo insertGroupeReservation($id_event, $nom_groupe, $nom, $prenom, $mail, $phone, $nom2, $prenom2, $mail2, $nom3, $prenom3, $mail3, $nom4, $prenom4, $mail4, $nom5, $prenom5, $mail5, $bdd);
      break;
      case "insertEntry":
        echo insertEntry($id_event, $nom_groupe, $nom, $prenom, $mail, $phone, $commande, $bdd);
      break;
		}
	}
}

/*Fonction getVisibility :
//Entrées : id_event
//Résultat : visible : 0 / 1
//Error : 0 : OK
*/

function getVisibility($id_event,$bdd){
  $res = array();

  if(!empty($id_event)){

    $getNombrePlaces = $bdd->prepare('SELECT * FROM SE_events WHERE id= ?');
    $getNombrePlaces->execute(array($id_event));
    $nombrePlaces = $getNombrePlaces->fetchAll( PDO::FETCH_ASSOC );

    $error = 0;

    if(!empty($nombrePlaces)){

      $value = array("name" => $nombrePlaces[0]['name']);
      array_push($res, $value);
      $value = array("places" => $nombrePlaces[0]['places']);
      array_push($res, $value);
      $value = array("visibility" => $nombrePlaces[0]['visible']);
      array_push($res, $value);
    }
    else{
        $error = 1;
    }
  }
  else{
    $error = 6;
  }

  $error_obj = array("error" => $error);
  array_push($res,$error_obj);

  return json_encode($res, JSON_PRETTY_PRINT);
}

  /*Fonction getPlaces :
  //Entrées : id_event
  //Résultat : nombre de place restantes de l'event
  //Error : 0 : OK
  */

  function getPlaces($id_event,$bdd){
  	$res = array();

  	if(!empty($id_event)){

  		$getNombrePlaces = $bdd->prepare('SELECT * FROM SE_events WHERE id= ?');
  		$getNombrePlaces->execute(array($id_event));
  		$nombrePlaces = $getNombrePlaces->fetchAll( PDO::FETCH_ASSOC );

  		$error = 0;

  		if(!empty($nombrePlaces)){

				$value = array("nom" => $nombrePlaces[0]['name']);
				array_push($res, $value);
        $value = array("places" => $nombrePlaces[0]['places']);
				array_push($res, $value);
  		}
  		else{
  				$error = 1;
  		}
  	}
  	else{
  		$error = 6;
  	}

  	$error_obj = array("error" => $error);
  	array_push($res,$error_obj);

  	return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction getGroupe :
  //Entrées : nom_groupe
  //Résultat : id_groupe
  //Error : 0 : OK
  */

  function getGroupe($nom_groupe,$bdd){
  	$res = array();

  	if(!empty($nom_groupe)){

  		$getIdGroupe = $bdd->prepare('SELECT * FROM SE_groupes WHERE groupe= ?');
  		$getIdGroupe->execute(array($nom_groupe));
  		$idGroupe = $getIdGroupe->fetchAll( PDO::FETCH_ASSOC );

  		$error = 0;

  		if(!empty($idGroupe)){

				$value = array("nom" => $idGroupe[0]['groupe']);
				array_push($res, $value);
        $value = array("id_groupe" => $idGroupe[0]['id']);
				array_push($res, $value);
        $value = array("id_respo" => $idGroupe[0]['id_respo']);
				array_push($res, $value);
  		}
  		else{
  				$error = 2;
  		}
  	}
  	else{
  		$error = 6;
  	}

  	$error_obj = array("error" => $error);
  	array_push($res,$error_obj);

  	return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction getReservations :
  //Entrées : id_event
  //Résultat : json des réservations visibles
  //Error : 0 : OK
  */

  function getReservations($id_event,$bdd){
  	$res = array();

  	if(!empty($id_event)){

  		$getReservations = $bdd->prepare('SELECT * FROM SE_reservation WHERE id_event = ? and valide = ?');
  		$getReservations->execute(array($id_event, 1));
  		$reservations = $getReservations->fetchAll( PDO::FETCH_ASSOC );

  		$error = 0;

  		if(!empty($reservations)){


        for($i = 0; $i<count($reservations) ; $i++){
          $resTmp = array();
    			$value = array("nom" => $reservations[0]['nom']);
    			array_push($resTmp, $value);
          $value = array("prenom" => $reservations[0]['prenom']);
    			array_push($resTmp, $value);
          $value = array("mail" => $reservations[0]['mail']);
    			array_push($resTmp, $value);
          $value = array("phone" => $reservations[0]['phone']);
    			array_push($resTmp, $value);
          $value = array("commande" => $reservations[0]['commande']);
    			array_push($resTmp, $value);
          array_push($res, $resTmp);
        }
  		}
  		else{
  				$error = 3;
  		}
  	}
  	else{
  		$error = 6;
  	}

  	$error_obj = array("error" => $error);
  	array_push($res,$error_obj);

  	return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction private validate :
  //Entrées : nom, prenom, token_mail
  //Résultat : valide la réservation de l'utilisateur
  //Error : 0 : OK
  */

  function validate($id_event, $nom, $prenom, $token_mail, $bdd){
    $res = array();

    if(!empty($id_event) && !empty($nom) && !empty($prenom) && !empty($token_mail)){

      $getReservation = $bdd->prepare('SELECT * FROM SE_reservation WHERE token_mail= ? and id_event= ?');
      $getReservation->execute(array($token_mail, $id_event));
      $reservation = $getReservation->fetchAll( PDO::FETCH_ASSOC );

      $error = 0;

      if(!empty($reservation)){

        if($reservation[0]['nom'] == $nom && $reservation[0]['prenom'] == $prenom){

          $update_valide = $bdd->prepare('UPDATE SE_reservation SET valide = ?, token_mail = ? WHERE id_event = ? AND nom = ? AND prenom = ? AND token_mail = ?');
          $update_valide->execute(array(1, "", $id_event, $nom, $prenom, $token_mail));

          decompteEvent($id_event,$bdd);
        }
        else{
          $error = 7;
        }
      }
      else{
          $error = 3;
      }
    }
    else{
      $error = 6;
    }

    $error_obj = array("error" => $error);
    array_push($res,$error_obj);

    return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction private validateGroupe :
  //Entrées : nom_groupe, token_mail
  //Résultat : valide l'inscription du groupe
  //Error : 0 : OK
  */

  function validateGroupe($nom_groupe, $token_mail, $bdd){
    $res = array();

    if(!empty($nom_groupe) && !empty($token_mail)){

      $getGroupe = $bdd->prepare('SELECT * FROM SE_groupes WHERE token_mail= ? and groupe= ?');
      $getGroupe->execute(array($token_mail, $nom_groupe));
      $reservation = $getGroupe->fetchAll( PDO::FETCH_ASSOC );

      $error = 0;

      if(!empty($reservation)){

          $update_valide = $bdd->prepare('UPDATE SE_groupes SET valide = ?, token_mail = ? WHERE groupe = ? AND token_mail = ?');
          $update_valide->execute(array(1, "", $nom_groupe, $token_mail));
          $update_valide = $bdd->prepare('UPDATE SE_reservation SET valide = ?, token_mail = ? WHERE token_mail = ?');
          $update_valide->execute(array(1, "", $token_mail));

          decompteEvent($reservation[0]['id_event'],$bdd);
      }
      else{
          $error = 2;
      }
    }
    else{
      $error = 6;
    }

    $error_obj = array("error" => $error);
    array_push($res,$error_obj);

    return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction private createGroupe :
  //Entrées : nom_groupe, nom_respo, prenom_respo, mail_respo)
  //Résultat : crée le groupe et le respo
  //Error : 0 : OK
  */

  function createGroupe($nom_groupe, $id_event, $nom_respo, $prenom_respo, $mail_respo, $phone_respo, $bdd){
    $res = array();

    if(!empty($nom_groupe) && !empty($id_event) && !empty($nom_respo) && !empty($prenom_respo) && !empty($mail_respo) && !empty($phone_respo)){

      $getGroupe = $bdd->prepare('SELECT * FROM SE_groupes WHERE id_event= ? and mail_respo= ?');
      $getGroupe->execute(array($id_event, $mail_respo));
      $groupe = $getGroupe->fetchAll( PDO::FETCH_ASSOC );

      $error = 0;

      if(empty($groupe)){
          $generate = sha1(rand()*rand()+time());
          //crée le respo
          $select_user = $bdd->prepare('INSERT INTO SE_reservation(id_event, id_groupe, nom, prenom, mail, phone, valide, token_mail) VALUES (?,?,?,?,?,?,?,?)');
          $select_user->execute(array($id_event, 0, $nom_respo, $prenom_respo, $mail_respo, $phone_respo, 0, $generate));
          //récupère son id
          $getReservation = $bdd->prepare('SELECT id FROM SE_reservation WHERE id_event= ? and nom = ? and prenom = ? and token_mail = ? and mail= ? and phone = ?');
          $getReservation->execute(array($id_event, $nom_respo, $prenom_respo, $generate, $mail_respo, $phone_respo));
          $reservation = $getReservation->fetchAll( PDO::FETCH_ASSOC );
          //crée le groupe avec l'id respo
          $select_user = $bdd->prepare('INSERT INTO SE_groupes (groupe, id_event, id_respo, mail_respo, valide, token_mail) VALUES (?,?,?,?,?,?)');
          $select_user->execute(array($nom_groupe, $id_event, $reservation[0]['id'], $mail_respo, 0, $generate));
          //get le groupe
          $getGroup = $bdd->prepare('SELECT id FROM SE_groupes WHERE groupe = ? and id_event = ? and id_respo = ? and mail_respo = ?');
          $getGroup->execute(array($nom_groupe, $id_event, $reservation[0]['id'], $mail_respo));
          $group = $getGroup->fetchAll( PDO::FETCH_ASSOC );
          //update le respo avec le groupe
          $update_valide = $bdd->prepare('UPDATE SE_reservation SET id_groupe = ? WHERE id_event= ? and nom = ? and prenom = ? and mail= ? and phone = ?');
          $update_valide->execute(array($group[0]['id'], $id_event, $nom_respo, $prenom_respo, $mail_respo, $phone_respo));

          sendMailGroupe($nom_groupe, $generate, $mail_respo);
      }
      else{
          $error = 4;
      }
    }
    else{
      $error = 6;
    }

    $error_obj = array("error" => $error);
    array_push($res,$error_obj);

    return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction insertEntry :
  //Entrées : id_event (id_groupe), nom, prenom, mail, (commande)
  //Résultat : inscrit un nouvel user à l'event (relatif selon l'id) avec commande et groupe en option
  //Error : 0 : OK
  */

  function insertEntry($id_event, $nom_groupe, $nom, $prenom, $mail, $phone_entry, $commande, $bdd){
    $res = array();

    if(!empty($id_event) && !empty($nom) && !empty($prenom) && !empty($mail) && !empty($phone_entry)){

      if(!isset($nom_groupe)){
        $id_groupe = '';
      }
      else{
        $getGroupe = $bdd->prepare('SELECT id FROM SE_groupes WHERE id_event= ? and groupe= ?');
        $getGroupe->execute(array($id_event, $nom_groupe));
        $groupe = $getGroupe->fetchAll( PDO::FETCH_ASSOC );
        $id_groupe = $groupe[0]['id'];
      }
      if(!isset($commande)){
        $commande = "";
      }
      if(!isset($phone_entry)){
        $phone_entry = "";
      }

      $getReservation = $bdd->prepare('SELECT * FROM SE_reservation WHERE id_event= ? and mail= ?');
      $getReservation->execute(array($id_event, $mail));
      $reservation = $getReservation->fetchAll( PDO::FETCH_ASSOC );

      $error = 0;

      if(empty($reservation)){
          $generate = 0;
          $generate = sha1(rand()*rand()+time()+$mail+$prenom+$nom);
          //crée la réservation
          $select_user = $bdd->prepare('INSERT INTO SE_reservation(id_event, id_groupe, nom, prenom, mail, phone, valide, token_mail, commande) VALUES (?,?,?,?,?,?,?,?,?)');
          $select_user->execute(array($id_event, $id_groupe, $nom, $prenom, $mail, $phone_entry, 0, $generate, $commande));

          sendMail($id_event, $nom, $prenom, $mail, $generate);
      }
      else{
          $error = 5;
      }
    }
    else{
      $error = 6;
    }

    $error_obj = array("error" => $error);
    array_push($res,$error_obj);

    return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction insertGroupeReservation :
  //Entrées : id_event, nom_groupe, nom, prenom, mail, nom2, prenom2, mail2, nom3, prenom3, mail3, nom4, prenom4, mail4, nom5, prenom5, mail5
  //Résultat : inscrit les 5 nouveaux user et crée leur groupe
  //Error : 0 : OK
  */

  function insertGroupeReservation($id_event, $nom_groupe, $nom, $prenom, $mail, $phone, $nom2, $prenom2, $mail2, $nom3, $prenom3, $mail3, $nom4, $prenom4, $mail4, $nom5, $prenom5, $mail5, $bdd){

    $nomArray = array($nom2, $nom3, $nom4, $nom5);
    $prenomArray = array($prenom2, $prenom3, $prenom4, $prenom5);
    $mailArray = array($mail2, $mail3, $mail4, $mail5);

    echo createGroupe($nom_groupe, $id_event, $nom, $prenom, $mail, $phone, $bdd);

    for($i = 0; $i < 4; $i++){
      echo insertEntry($id_event, $nom_groupe, $nomArray[$i], $prenomArray[$i], $mailArray[$i], $nom_groupe, $commande, $bdd);
    }
  }

  /*Fonction private decompteEvent :
  //Entrées : id_event
  //Résultat : retire 1 au nombre de place de l'event
  //Error : 0 : OK
  */

  function decompteEvent($id_event, $bdd){
    $res = array();

    if(!empty($id_event)){

      $getEvent = $bdd->prepare('SELECT * FROM SE_events WHERE id= ?');
      $getEvent->execute(array($id_event));
      $event = $getEvent->fetchAll( PDO::FETCH_ASSOC );

      $error = 0;

      if(!empty($event)){
          //update le nombre de places restantes
          $update_places = $bdd->prepare('UPDATE SE_events SET places = ? WHERE id= ?');
          $update_places->execute(array($event[0]['places']-1, $id_event));
      }
      else{
          $error = 3;
      }
    }
    else{
      $error = 6;
    }

    $error_obj = array("error" => $error);
    array_push($res,$error_obj);

    return json_encode($res, JSON_PRETTY_PRINT);
  }

  /*Fonction private sendMail
  //Entrées : id_event, nom, prenomm, token
  //Résultat envoi d'un mail avec les données et génération du lien d'activation
  //Error : 0 : OK
  */

  function sendMail($id_event, $nom, $prenom, $mail, $token_mail){

    $nom = str_replace(' ','%20',$nom);
    $prenom = str_replace(' ','%20',$prenom);
    $mail = str_replace(' ','%20',$mail);
    $url = "http://benjaminbu.town/api/apiSE.php?action=validate&id_event=" . $id_event . "&token=" . $token_mail ."&nom=".$nom."&prenom=".$prenom."";

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
    $bim="Pour valider ta commande, clique sur le lien suivant : " . $passage_ligne . $url;
    $modif="À partir de ce moment, tu seras considéré comme inscrit !";
     $sign="Hélios";
     $fb="http://www.facebook.com/benjamin.butown";
     //$desol="Désolé pour ceux qui le reçoivent pour la deuxième fois.";
    //=====Définition du sujet.
    $sujet = "Inscription à une activité d'Hélios";
    //=========

    //=====Création du header de l'e-mail.
    $header = "From: \"Hélios\"<contact@benjaminbu.town>".$passage_ligne;
    $header.= "Reply-to: \"Hélios\" <contact@benjaminbu.town>".$passage_ligne;
    $header.= "MIME-Version: 1.0".$passage_ligne;
    $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
    //==========

    //=====Création du message.
    $message = $passage_ligne."--".$boundary.$passage_ligne;
    //=====Ajout du message au format texte.
    $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
    $message.= $passage_ligne.$bim.$passage_ligne.$passage_ligne.$modif.$passage_ligne.$passage_ligne.$sign.$passage_ligne.$fb;
    //==========

    //==========
    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
    //==========

    //=====Envoi de l'e-mail.
    mail($mail,$sujet,$message,$header);
  }


  /*Fonction private sendMailGroupe
  //Entrées : nom_groupe, token_mail
  //Résultat envoi d'un mail avec les données et génération du lien d'activation
  //Error : 0 : OK
  */

  function sendMailGroupe($nom_groupe, $token_mail, $mail){
    $nom_groupe = str_replace(' ','%20',$nom_groupe);
    $url = "http://benjaminbu.town/api/apiSE.php?action=validateGroupe&nom_groupe=" . $nom_groupe . "&token=" . $token_mail."";

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
    $bim="Pour valider ta commande, clique sur le lien suivant : " . $passage_ligne . $url;
    $modif="À partir de ce moment, toi et ton groupe serez considérés comme inscrit !";
     $sign="Hélios";
     $fb="http://www.facebook.com/benjamin.butown";
     //$desol="Désolé pour ceux qui le reçoivent pour la deuxième fois.";
    //=====Définition du sujet.
    $sujet = "Inscription à une activité d'Hélios";
    //=========

    //=====Création du header de l'e-mail.
    $header = "From: \"Hélios\"<contact@benjaminbu.town>".$passage_ligne;
    $header.= "Reply-to: \"Hélios\" <contact@benjaminbu.town>".$passage_ligne;
    $header.= "MIME-Version: 1.0".$passage_ligne;
    $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
    //==========

    //=====Création du message.
    $message = $passage_ligne."--".$boundary.$passage_ligne;
    //=====Ajout du message au format texte.
    $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
    $message.= $passage_ligne.$bim.$passage_ligne.$passage_ligne.$modif.$passage_ligne.$passage_ligne.$sign.$passage_ligne.$fb;
    //==========

    //==========
    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
    //==========

    //=====Envoi de l'e-mail.
    mail($mail,$sujet,$message,$header);
  }
