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
		<link rel="stylesheet" type='text/css' href="vue/svg.css" />
		<link rel="stylesheet" type='text/css' href="vue/include/espace_membre/zone_membre.css" />
		
		<script src="vue/jquery-2.1.4.min.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

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
			
			<div class="reglement">
				<h1>
					<svg xmlns="http://www.w3.org/2000/svg">

	                    <line class="top_right" x1="50%" y1="0" x2="100%" y2="0"/>
	                    <line class="top_left" x1="0" y1="0" x2="50%" y2="0"/>

	                    <line class="bot_right" x1="50%" y1="100%" x2="100%" y2="100%"/>
	                    <line class="bot_left" x1="0" y1="100%" x2="50%" y2="100%"/>

	                    <line class="right" x1="100%" y1="0" x2="100%" y2="100%"/>
	                    <line class="left" x1="0" y1="0" x2="0" y2="100%"/>
                	</svg>
                	GRAND JEU CONCOURS® 
                </h1>

				<div class="border"></div>

				<h2>
					<svg xmlns="http://www.w3.org/2000/svg">
						<line class="border_obj" x1="0" y1="43" x2="190" y2="43"/>
					</svg>
					I. Objectif :
				</h2>

				<p>Gagnez le plus de points !</p>

				<h2>	
					<svg xmlns="http://www.w3.org/2000/svg">
						<line class="border_comment" x1="0" y1="43" x2="215" y2="43"/>
					</svg>
					II. Comment :
				</h2>

				<p>Tout d’abord connecte toi sur le site grâce à ton adresse ESIEE et associe ton compte Snapchat à ton compte ESIEE <i class="fa fa-smile-o"></i><br><br>
				Chaque semaine, suis le voyage de Benjamin et viens lui en aide pour gagner des points !</p>

				<h2>
					<svg xmlns="http://www.w3.org/2000/svg">
						<line class="border_points" x1="0" y1="43" x2="235" y2="43"/>
					</svg>
					III. Les points :
				</h2>

				<p>
				    Chaque snap vaut 50 points !<br><br><br>
				Mais si tu es parmi les 2 plus rapides ou originaux tu auras le droit à un bonus :<br>
				<ol>
					Premier:  50 points pour le snap +  50 points bonus<br></br>
					Deuxième: 50 points pour le snap + 30 points bonus
				</ol>
				</p>

				<div class="border"></div>

				<p class="important">3 moyens de gagner :</p>

				<ol>
				    <li>Tout d’abord les 3 premiers au classement général ( jeux et snap ) seront vainqueurs !</li>
				    </br><li>Pour ceux qui étaient si proche de gagner ne vous en faites pas, en fonction du nombre de point que vous aurez obtenu nous ferons un tirage au sort de 3 autres gagnants. Plus vous aurez de points et plus la chance d’être tiré au sort sera élevée alors ne vous découragez pas !</li>
				    </br><li>Restez aux aguets pour des défis « flash » (un snap à envoyer directement sur place). Le premier à le faire recevra un petit cadeau pour sa rapidité !</li>
				</ol>

				<p class="important">A vos marques, prêt, snappez !</p>

			</div>
			
		</div>

		<?php include_once('vue/include/menupanel.php'); ?> <!-- Inclus le MenuPanel  -->

		<script type="text/javascript">
		$("svg").hide();
		$(".important:eq(1)").hide();
	
		var scroll_max = $(document).height() - $(window).height();
		console.log(scroll_max);
		console.log($(document).scrollTop());
		console.log($(document).height() );

 $(document).scroll(function() {

		if(scroll_max < 100 ){
	 	 		$(".important:eq(1)").show();
				$(".important:eq(1)").addClass("zoomInDown");
				$("h1").addClass("animate_border");
				$("svg:eq(0)").show();
	 	 }
	 	 else{
				if($(document).scrollTop() >=  scroll_max/100*10 ){
					$("h1").addClass("animate_border");
					$("svg:eq(0)").show();
		 	 	}

		 	 	if($(document).scrollTop() >= scroll_max/100*20 ){
					$("h2:eq(0)").addClass("animate_obj");
					$("svg:eq(1)").show();
		 	 	}

		 	 	if($(document).scrollTop() >= scroll_max/100*40 ){
					$("h2:eq(1)").addClass("animate_coments");
					$("svg:eq(2)").show();
		 	 	}

		 	 	if($(document).scrollTop() >= scroll_max/100*60 ){
					$("h2:eq(2)").addClass("animate_points");
					$("svg:eq(3)").show();
		 	 	}

				if($(document).scrollTop() >= scroll_max/100*90 ){
		 	 		$(".important:eq(1)").show();
					$(".important:eq(1)").addClass("zoomInDown");
		 	 	}
			}
		});

		</script>	
	
	</body>

</html>