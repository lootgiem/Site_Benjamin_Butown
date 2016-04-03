<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>
<!DOCTYPE html>

<html lang="fr-fr">

	<head>
	
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="">
    	<meta name="author" content="Benjamin Butown">

    	<link rel="icon" href="vue/images/bbutown.gif">

		<link rel="stylesheet" href="vue/font-awesome-4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type='text/css' href="vue/style.css" />
		<link rel="stylesheet" type='text/css' href="vue/responsive.css" />
		<link rel="stylesheet" type='text/css' href="vue/include/espace_membre/zone_membre.css" />
		<script src="vue/jquery-2.1.4.min.js"></script>

		<title>Benjamin Butown</title>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body>
		<div id="mainPage">

		<?php include_once('vue/include/header.php'); 
			
			if(isset($_SESSION['token'])){												//Selection du profil à afficher
				include_once('vue/include/espace_membre/zone_profil.php');
			}
			else{
				include_once('vue/include/espace_membre/zone_connection.php'); 
			}
		?>	
		</div>

		<?php include_once('vue/include/menupanel.php'); ?> <!-- Inclus le MenuPanel  -->

	</body>

</html>