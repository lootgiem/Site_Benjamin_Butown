<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>

<header>
		<div id="logo"><a href="index.php"><img src="vue/images/logo/benjamin_butown_logo_300.gif"></a></div>
		<nav>
			<ul id="menu">
				<li>
					<a href="index.php?page=actus">ACTUALITES</a>
				</li>
				<li class="itemLeft">
					<a href="index.php?page=jeux">JEUX</a>
				</li>
				<li class="itemRight">
					<a href="index.php?page=membres">MEMBRES</a>
				</li>
				<li>
					<a href="index.php?page=profil">
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