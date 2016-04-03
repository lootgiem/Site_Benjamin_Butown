<?php

include("./data.php");

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table app_news
$reponse = $bdd->query('SELECT * FROM app_photos ORDER BY id DESC');


$donnees = $reponse->fetchAll( PDO::FETCH_ASSOC );
	$emparray['pictures'] = $donnees;
echo json_encode($emparray);
//write to json file
    $fp = fopen('picturesData.json', 'w');
    fwrite($fp, json_encode($emparray));
    fclose($fp);
	
$reponse->closeCursor(); // Termine le traitement de la requête

?>