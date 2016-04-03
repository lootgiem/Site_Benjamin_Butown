<?php 
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
?>

<div class="zone_de_connection">
		 
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

	<form action="index.php?page=action/change_state" method="post">

		<div class="label_input_co">
			 <label class="label_co" for="user"> Pseudo <i class="fa fa-user"></i> :</label>
			 <input id="input_co" type="text" value="<?php if(isset($_COOKIE['user'])){echo $_COOKIE['user'];}?>" name="user"/>

			 <label class="label_co" for="password">Mot de passe <i class="fa fa-lock"></i> :</label>
			 <input class="input_co" type="password" name="password" />
			 <div class="mdp_forget">
				<a href="index.php?page=forget">Mot de Passe oublié ?</a>
			</div>
		</div>
		<div id="checkbox">
			<label class="checkbox" type="checkbox" for="case"> Conserver le pseudo :</label>
			<input class="checkbox_input" type="checkbox" name="keep_user" id="case" checked="checked" />
		</div>
		<input id="submite" class="btn full" type="submit" value="Se connecter">

	</form> 

</div>

<a href="index.php?page=inscription">
		<div class="inscrire btn full">
			S'inscrire
		</div>
</a>
