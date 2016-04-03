<?php
defined("_Inclusion_autorisee_") or die("Inclusion directe non autorisee");
$secu_form = sha1(uniqid(microtime(), true));
$_SESSION['secu_form'] = $secu_form;

    //On affiche le formulaire       
        if(isset($_GET['success']) && $_GET['success'] == "true")
        {

            header('location:index.php?page=profil');
            exit();
           /*echo '<div class="message">
                        Bravo ! Vous êtes inscrit.</br> 
                        Vous pouvez dès maintenant vous <a title ="Ce connecter" href="index.php?page=profil"><u>connecter</u></a>.
                        </br></br>
                    </div>';*/
        }

    ?>       
        <form id="formulaire_inscription" action="index.php?page=action/send_inscription" method="post">
            <h1>Inscription</h1>
            <?php 
                if(isset($_GET['m_n']) && !empty($_GET['m_n']))  //On affiche un message s'il y a lieu
                {
                    echo '<div class="avertissement negatif" ><i class="fa fa-exclamation-triangle"></i>'.htmlentities($_GET['m_n'], ENT_QUOTES, 'UTF-8').'</div></br>';
                }
            ?>
            <div>
                <label for="user">Nom d'utilisateur :</label>
                <input maxlength="24" type="text" name="user" value="<?php if(isset($_GET['user'])){echo $_GET['user'];}?>"/><br />
               
                <label for="mail">Email ESIEE:</label>
                <input type="text" name="mail" value="<?php if(isset($_GET['mail'])){echo $_GET['mail'];}?>"/><br />
                <span class="small">(Pour recevoir tes recompenses)</span>

                <label style="margin-top:19px;" for="snapchat">Snapchat :<br/>
                    <span class="small">(optionnel)</span>
                </label>
                <input maxlength="24" type="text" name="snapchat" value="<?php if(isset($_GET['snapchat'])){echo $_GET['snapchat'];}?>"/>
                    <span class="small">(Pour valider nos d&eacute;fis)</span>
               
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" /><br />
                    <span class="small">6 caract&egrave;res minimum</span><br />
               
                <label style="margin-top:19px;" for="passverif">Vérification du Mot de passe :</label>
                <input type="password" name="passverif" /><br /><br />

                <input type="hidden" name="id_form" value="<?php echo $secu_form ?>" />

                <input id="submite" type="submit" value="Inscription" />
            </div>
        </form>  

