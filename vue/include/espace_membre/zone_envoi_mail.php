<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>
	

	<div class="zone_oublie">

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

		<form action="index.php?page=action/envoi_mail" method="post">
			<labelfor="user"> Entrer le nom d'utilisateur de votre compte:</label>
			<input  type="text" name="user"/>			
			<input id="submite" class="btn full" type="submit" value="Envoyer">
		</form> 

	</div>

		
