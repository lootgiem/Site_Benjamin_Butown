<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");

if(!isset($_SESSION['secu_form']) || !isset($_POST["id_form"]) || $_SESSION['secu_form'] !== $_POST["id_form"] ){
	
	$error = return_message(6);
	header('Location: index.php?page=inscription&m_n='.$error);
	exit();	
}
else{

	if( isset($_SESSION["tentative"]) && $_SESSION["tentative"]<=0 ) 
		{
			$error = return_message(18);
			header('Location: index.php?page=inscription&m_n='.$error);
			exit();
		}
		else if(!isset($_SESSION["tentative"]))
		{
			$_SESSION["tentative"] = 10;
		}

		if( (isset($_SESSION["tentative"]) && $_SESSION["tentative"] > 0 ) ){

			include_once('modele/espace_membre/inscription.php');
			extract(inscription());


			$parametre = '&success='.$reussi; 
			if($reussi != 'true'){
				if(!empty($message)){$parametre .= "&m_n=".$message;}
				if(isset($_POST['user']) AND !empty($_POST['user']) ){$parametre .= "&user=".$_POST['user'];}
				if(isset($_POST['mail']) AND !empty($_POST['mail']) ){$parametre .= "&mail=".$_POST['mail'];}
				if(isset($_POST['snapchat']) AND !empty($_POST['snapchat']) ){$parametre .= "&snapchat=".$_POST['snapchat'];}
				header('Location: index.php?page=inscription'.$parametre);
				exit(); 
			}
			else{
				$_SESSION["tentative"]--;
				header('Location: index.php?page=profil&m_p=Inscription réussi');
				exit(); 

			}
		}
}

