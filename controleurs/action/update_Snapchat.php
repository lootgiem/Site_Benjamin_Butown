<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");

if(isset($_SESSION['token'],$_SESSION['user'])){   						

	include_once('modele/profile/update_Snapchat.php');
	extract(update_Snapchat());	
	/*$var = array( 'reussi' , 'message');*/

	if( $reussi == "true" ){
		header('Location: index.php?page=profil&m_p='.$message);
		exit();
	}

header('Location: index.php?page=profil&m_n='.$message);
exit(); 

}