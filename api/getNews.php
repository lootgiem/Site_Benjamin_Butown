<?php

include("./data.php");

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table app_news
//$reponse = $bdd->query('SELECT * FROM app_news ORDER BY id DESC LIMIT 10');
$reponse = $bdd->query('SELECT * FROM app_news ORDER BY id DESC');


$donnees = $reponse->fetchAll( PDO::FETCH_ASSOC );
//	echo json_encode($donnees);
	$emparray['news'] = $donnees;
echo json_encode($emparray);
//write to json file
    $fp = fopen('newsData.json', 'w');
    fwrite($fp, json_encode($emparray));
    //fwrite($fp, "Bite");
    fclose($fp);
	
$reponse->closeCursor(); // Termine le traitement de la requête

?>