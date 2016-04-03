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

		<title>Scores</title>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body onload="control_aff(0,<?php if(isset($_GET['jeu']) && !empty($_GET['jeu'])){echo "'".$_GET['jeu']."'";}else{echo "0";}?>)"> <!-- Affiche dans l'ordre décroissant avec le jeu dans l'url au chargement de la page -->
		<div id="mainPage">
				<p id="mainTextGames" class="score_title">Scores</p>

			<?php if(!isset($_SESSION['token'])){ ?>
					<div class="message" style='font-size : 18px;'>
						<i class="fa fa-exclamation-triangle"></i> Vous pouvez vous <a title ="Se connecter" href="index.php?page=profil"><u>connecter</u></a>, ou vous <a title ="S'inscrire" href="index.php?page=inscription"><u>inscrire</u></a> pour obtenir vos scores personnels</br></br></br>				
					</div>
			<?php } ?>
					
				<span class="annonce_score">
						Afficher les scores pour :
						<select id="liste" name="liste" onchange ="control_aff(0,0)" >
							<!-- Liste des jeux -->
						</select>
				</span>

				<div id="tab_score">
					<!-- Tableau des scores -->
				</div>


			</div>
		</div>
		<div id="backIcon" onclick="back_to_last_page();"><i class="fa fa-undo"></i></div>
		<?php
			 include_once('vue/score/fonction_js.php');  
		?>
	</body>

</html>
