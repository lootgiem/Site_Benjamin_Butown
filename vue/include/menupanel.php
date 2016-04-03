<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>

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