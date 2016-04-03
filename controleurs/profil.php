<?php
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");

if( isset($_SESSION['token'],$_SESSION['user']) ){		
	include_once("modele/profile/snapchat.php");
	include_once("modele/profile/mail.php");
	$nom_compte_snap = get_snapchat_account();
	$nom_mail_compte = get_mail_account($_SESSION['user']);
}

include_once('vue/profil.php');	
