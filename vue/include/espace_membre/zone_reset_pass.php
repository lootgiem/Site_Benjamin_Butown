<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>

<div class="zone_de_reset_pass">
		 
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

 	<?php if(isset($_GET['mail']) && isset($_GET['token'])){ ?>
		<h3>Reinitialiser votre mot de passe : </h3>
			<form action="index.php?page=action/createPassword&mail=<?php echo $_GET['mail'];?>&token=<?php echo $_GET['token'];?>" method="POST">
				Password:
				<input type="password" name="password"/>
				Repété:
				<input type="password" name="passwordRepeat"/>
				<input id="submite" type="submit" value="Envoyer" />
			</form>
 	<?php }
 	else {
 		echo "Erreur : Token ou mail non renseigné !";
 	} ?>


</div>

