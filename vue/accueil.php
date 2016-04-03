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

			<?php include_once('vue/include/header.php'); ?>
			
			<section>
				<!-- <img id="slogan" src="images/slogan.png"> -->
				<p id="slogan">Deux nouveaux jeux viennent de sortir</p>
                <!--<div id="accueil_btn">
                	<a class="btn full"  href="index.php?page=inscription">
                        <div class="actu_inscription">
                            M'inscrire
                        </div>
                    </a>
                    <a class="btn full"  href="index.php?page=reglement">
                        <div class="actu_inscription">
                            <i class="fa fa-book"></i> Le Règlement
                        </div>
                    </a>
                </div>-->
				<article class="divLink">
					<h2>Butown Tap</h2>
					<p>A vos marques, prêts, tapez !!!<br>
						<img src="vue/images/appli_games/butown_tap.gif">
					</p>
					<a class="btn full" target="_blank" href="https://play.google.com/store/apps/details?id=town.benjaminbu.butowntap&hl=fr">Play Store</a>
					<a class="btn full" target="_blank" href="vue/jeux/butowntap/index.html">Version web</a>
				</article>
				<article class="divLink">
					<h2>Butown Hero</h2>
					<p>Gardez le rythme !<br>
						<img src="vue/images/appli_games/butown_hero.gif">
					</p>
					<a class="btn full" target="_blank" href="https://play.google.com/store/apps/details?id=town.benjaminbu.butownhero&hl=fr">Play Store</a>
					<a class="btn full" target="_blank" href="vue/jeux/butownhero/index.html">Version web</a>
				</article>
			</section>
		</div>

		<?php include_once('vue/include/menupanel.php'); ?> <!-- Inclus le MenuPanel  -->

	</body>

</html>