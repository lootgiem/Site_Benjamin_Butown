
<html lang="fr-fr">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
    	<meta name="description" content="">
    	<meta name="author" content="Benjamin Butown">

    	<link rel="icon" href="../../vue/images/bbutown.png">

		<link rel="stylesheet" href="../../vue/font-awesome-4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" type='text/css' href="../../vue/style.css" />
		<link rel="stylesheet" type='text/css' href="../../vue/responsive.css" />
		<link rel="stylesheet" type='text/css' href="../../vue/include/espace_membre/zone_membre.css" />
		<link rel="stylesheet" type='text/css' href="admin.css" />
		<script src="../../vue/jquery-2.1.4.min.js"></script>

		<title>Benjamin Butown - Actualités</title>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>

	<body >
		<div id="mainPage">

				<header>
					<div id="logo"><a href="../../index.php"><img src="../../vue/images/logo/benjamin_butown_logo_300.png"></a></div>
					<nav>
						<ul id="menu">
							<li>
								<a href="../../index.php?page=actus">ACTUALITES</a>
							</li>
							<li class="itemLeft">
								<a href="../../index.php?page=jeux">JEUX</a>
							</li>
							<li class="itemRight">
								<a href="../../index.php?page=membres">MEMBRES</a>
							</li>
							<li>
								<a href="../../index.php?page=profil">
								<?php
									if(isset($_SESSION['token'])){												//Selection du profil à afficher
										echo "<i class='fa fa-user'></i> PROFIL";
									}
									else{
										echo "CONNEXION"; 
									}
								?>
								</a>
							</li>
						</ul>
					</nav>
					<div class="clear"></div>
				</header>


				<!--Message-->
				

				<?php
	
				 if(isset($_GET['m_p']) && !empty($_GET['m_p'])) 
			        {
			                echo '<div class="avertissement positif">'.htmlentities($_GET['m_p'], ENT_QUOTES, 'UTF-8').'<i class="fa fa-check fa-2x"></i></div></br>';
			        }
			     if(isset($_GET['m_n']) && !empty($_GET['m_n'])) 
			        {
			                echo '<div class="avertissement negatif"><i class="fa fa-exclamation-triangle"></i>'.htmlentities($_GET['m_n'], ENT_QUOTES, 'UTF-8').'</div></br>';
			        }
			 	 ?>

				<!--debut du formulaire-->

				<form class="ajax" action="admin.php" method="get">
					<p>
						<label class="champ_search"for="search">Rechercher un pseudo Snapchat :</label>
						<input onload="rechercher()" type="text" name="search" id="search" value ="<?php if(isset($_GET['search'])){echo $_GET['search'];}?>"/>
					</p>
				</form>
				<br><br>
				<div id="results"></div>

				<script type="text/javascript">
						

				$(document).ready( function() {

				$field = $(":input");
				
				rechercher();

				function rechercher(){
				    $.ajax({
					  	type : 'GET', 
						url : 'ajax_search.php' , 
						data : 'search='+ $field.val() , 
						beforeSend : function() { 
							$('#results').after('<img src="../../vue/images/ajax-loader.gif" alt="loader" id="ajax-loader" />');
						},
						success : function(data){
							$('#ajax-loader').remove(); 
							$('#results').html(data);
						}
					      });
				}

				  $('#search').keyup( function(){
				  	
						
					    $('#results').html('');
					    $('#ajax-loader').remove(); 
					 
					    if( $field.val().length > 1 )
					    {
							rechercher();
					    }
				  });

				});

				</script>
								
		</div>
		
		<div id="menuIcon" onclick="showHideMenuPanel();"><i class="fa fa-bars"></i></div>
		<div id="menuPanel" class="blur">
			<div class="blur">
				<ul>
					<li>
						<a href="index.php?page=actus">ACTUALITES</a>
					</li>
					<li>
						<a href="index.php?page=jeux">JEUX</a>
					</li>
					<li>
						<a href="index.php?page=membres">MEMBRES</a>
					</li>
					<li>
						<a href="index.php?page=profil">
						<?php
							if(isset($_SESSION['token'])){									//Selection du profil à afficher
								echo "<i class='fa fa-user'></i> PROFIL";
							}
							else{
								echo "CONNEXION"; 
							}
						?>
						</a>
					</li>
				</ul>
			</div>
		</div>
		<script type="text/javascript">
			function showHideMenuPanel() {
				if ($("#menuPanel").is(":visible")) {
					$("#menuPanel").hide();
				}
				else {
					$("#menuPanel").show();
				}
			}
		</script>

	</body>

</html>