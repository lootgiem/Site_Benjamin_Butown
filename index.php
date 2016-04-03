<?php
session_start();
define("_Inclusion_autorisee_", true);

include_once('modele/message.php');

if (!empty($_GET['page']) AND is_file('controleurs/'.$_GET['page'].'.php'))
{
    include_once('controleurs/'.$_GET['page'].'.php');
}
else{

	include_once('controleurs/accueil.php');
}

