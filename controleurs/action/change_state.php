<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");

if(!isset($_SESSION['token'])){   													/*POUR LA CONNEXION*/


	/*Sauvegarde Nom utilisateur*/
	if( isset($_POST['keep_user']) ){
		if($_COOKIE['user'] != $_POST['user']) {
			setcookie('user', $_POST['user'], time() + 31*24*3600, null, null, false, true);
		}
	}
	else{
		setcookie('user','', time() + 31*24*3600, null, null, false, true);
	}

	include_once('modele/espace_membre/connection.php');
	extract(connection_site());	
	/*$var = array( 'reussi' , 'message' , 'token');*/
	
	if( $reussi == "true" && !empty( $token )) {

		$_SESSION['user'] = $_POST['user'];
		$_SESSION['token'] = $token;
		header('Location: index.php?page=profil&m_p='.$message);
		exit();
	}

	header('Location: index.php?page=profil&m_n='.$message);
	exit(); 

	/*$referer = $_SERVER['HTTP_REFERER'] != null ? $_SERVER['HTTP_REFERER'] : 'index.php?page=';
	$url_parse = parse_url($referer, PHP_URL_QUERY);
	$tab = explode("&", $url_parse);

	if(!empty($tab[0]) AND strpos("'".$tab[0]."'",'page')){
		header('Location: index.php?'.$tab[0].'&message_membre='.$message_membre);
	}
	else{
		header('Location: index.php?message_membre='.$message_membre);
	}*/


}
else if( isset($_SESSION['token']) ){	

	if(!empty($_SESSION['token']) AND $_SESSION['token'] == $_GET['token']){		/*POUR LA DECONNEXION*/

		include_once('modele/espace_membre/deconnexion.php');
		extract(deconnexion_site());
		/*  $var = array( 'reussi' , 'message'); */
		session_unset();
		session_destroy();
		if($reussi == "true"){
			header('Location: index.php?page=profil&m_p='.$message);
			exit(); 
		}
		header('Location: index.php?page=profil&m_n='.$message);
		exit(); 
	}
}

/*probleme Token*/
$message = return_message(6);
header('Location: index.php?page=profil&m_n='.$message);
exit(); 


