<?php 

	function return_message($id){
		switch ($id) {
			    case 1:
			   		$message = "Le pseudo est déjà utilisé, merci d'en choisir un autre.";
			        break;
			    case 2:
			  		$message = "Ce mail est déjà utilisé.";
			        break;
			    case 3:
			        $message = "Merci de renseigner votre adresse E-mail dans ce format : prenom.nom@edu.esiee.fr ou @esiee.fr ";
				    break;
			    case 4:
				    $message = "Certains champs son vide, merci de les compléter.";
				    break;
			    case 5:
				    $message = "Utilisateur inconnue ou identifiants incorrects";
				    break;
			    case 6:
				    $message = "Problemes : Token invalide";
				    break;
			    case 7:
				 	$message = "Vous êtes déja déconnecté";
				    break;
			    case 8:
				    $message = "Pas de score pour l'utilisateur";	
				    break;
			    case 9:
				    $message = "Utilisateur non connecté, Merci de vous déconnecter et vous reconnecter";
				    break;
				case 10:
				    $message = "Il n'y à pas de jeu à ce nom";
				    break;
				case 11:
				    $message = "Ce compte snapchat est déjà utilisé";
				    break;
				case 12:
				    $message = "L'identifiant que vous avez entré ne peut être constitué que de lettre et de tiret.";
				    break;    
			    case 13:
				    $message = "Le mot de passe que vous avez entré contien moins de 6 caractères.";
				    break;
			    case 14:
				    $message = "Les mots de passe que vous avez entré ne sont pas identiques.";
				    break;
				case 15:
				    $message = "Vous êtes connecté !";
				    break;
				case 16:
				    $message = "Vous avez été déconnecté !";
				    break;
				case 17:
				    $message = "Votre compte Snapchat a été modifié avec succés";
				    break;
				case 18:
				    $message = "Trop d'inscription, retente plus tard !";
				    break;
			 	default:
					$message = "Unknown";
				
			}
			
		return $message;
	}


