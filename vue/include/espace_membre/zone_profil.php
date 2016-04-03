<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>

	

	<div class="profil">

		<?php
	
		 if(isset($_GET['m_p']) && !empty($_GET['m_p'])) 
		    {
		            echo '<div class="avertissement positif">'.htmlentities($_GET['m_p'], ENT_QUOTES, 'UTF-8').'<i class="fa fa-check fa-2x"></i></div>';
		    }
		 if(isset($_GET['m_n']) && !empty($_GET['m_n'])) 
		    {
		            echo '<div class="avertissement negatif"><i class="fa fa-exclamation-triangle"></i>'.htmlentities($_GET['m_n'], ENT_QUOTES, 'UTF-8').'</div>';
		    }
		?>

		<div class="message_accueil">
		 Bonjour <?php if(isset($_SESSION['user'])){echo "<i>".htmlentities($_SESSION['user'], ENT_QUOTES, 'UTF-8')."</i>";} ?> !
		</div>
<!-- $nom_mail_compte -->

		<div class="content_profil">
			<div class="compte_snap">
				<?php
					if(!empty($nom_mail_compte)){
				?>	
					    Mail ESIEE : <?php echo $nom_mail_compte ?> 
				<?php
					}
					else{
				?>
						Problème : Votre compte n'est associé avec aucune adresse ESIEE!
				<?php
					}
				?>
			</div>

			<div class="compte_snap">
				<?php
					if(!empty($nom_compte_snap)){
				?>	
					    Compte snapchat associé : <?php echo $nom_compte_snap ?> 
					    <!-- Affiche la table du jeu snapchat -->
  					     <br/><br/><a title ="Voir mon score" href="index.php?page=score&jeu=snapchat"><i><i class="fa fa-search"></i> Voir mon score snapchat</i></a></br> 

				<?php
					}
					else{
				?>
						Votre compte n'est associé avec aucun compte snapchat !
				<?php
					}
				?>
			</div>


			<a href="#">
				<div class="Snapchat" onclick='showHide_FormSnap()'>
				</br> Ajouter/Modifier mon compte Snapchat <i style=' display:none;'class="fa fa-arrow-down"></i><i class="fa fa-arrow-right"></i>
				</div>
			</a>

			<div class="update_snap" style='display:none;'>
				<div class="avertissement negatif">
					<i style="font-size=12px;" class="fa fa-exclamation-triangle"></i> Attention, vous allez perdre votre score Snapchat si vous modifez le nom du compte Snapchat actuellement associé
				</div>
				</br>
				<form id="formulaire_update_Snapchat" action="index.php?page=action/update_Snapchat" method="post">
				    <label for="snapchat">Snapchat :</label>
				    <input class="textbox" type="text" name="snapchat" value=''/><br/>
				    <input id="submite" class="btn full" type="submit" value="Modifier" />
				</form>
			</div>

			<script type="text/javascript">
				function showHide_FormSnap(){
					if ($(".update_snap").is(":visible")) {
						$(".fa-arrow-down").hide();
						$(".fa-arrow-right").show();
						$(".update_snap").hide();
					}
					else {
						$(".update_snap").show();
						$(".fa-arrow-right").hide();
						$(".fa-arrow-down").show();
					}
				}
			</script>

			<a href="index.php?page=reglement">
				<div class= "lien_reglement">
					<i class="fa fa-book"></i> Lire le règlement Snapchat
				</div>
			</a>

			<a href="index.php?page=action/change_state&token=<?php echo $_SESSION['token']?>">
				<div class="disconnect">
			 		 Me déconnecter <i class="fa fa-power-off"></i> 
			 	</div>
			</a>
		</div>
	</div>