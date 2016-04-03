<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");

$expire = 5*60;

if( !isset( $_COOKIE['mail_stop'] ) ){
	if(isset($_POST['user']) && !empty($_POST['user'])){
		include_once("modele/profile/mail.php");
		$nom_mail_compte = get_mail_account($_POST['user']);

			if(!empty($nom_mail_compte)){

				include_once('modele/espace_membre/forget.php');
				$error = envoi_mail($nom_mail_compte);	
				if($error == 0){
					setcookie('mail_stop',time()+$expire, time()+$expire);
					header("Location: index.php?page=forget&m_p=Email de récupération envoyé à l'adresse ESIEE associé au compte ");
					exit();
				}
				else{
					header('Location: index.php?page=forget&m_n='.return_message($error));
					exit();	
				}
			}
			else{
				header('Location: index.php?page=forget&m_n='.return_message(5));
				exit();	
			}
	}
	else{
		header('Location: index.php?page=forget&m_n='.return_message(4));
		exit();	
	}
}
else{
		$temps_restant = ($_COOKIE['mail_stop'] - time());
		header('Location: index.php?page=forget&m_n=Vous devez attendre '.$temps_restant .' secondes avant de pouvoir renvoyer un mail.');
		exit();	
}
