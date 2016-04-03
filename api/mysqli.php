<?php
    $host_name  = "db609503474.db.1and1.com";
    $database   = "db609503474";
    $user_name  = "dbo609503474";
    $password   = "btD4F45GH6";

    $bdd = mysqli_connect($host_name, $user_name, $password, $database);
    if (mysqli_connect_errno())
    {
    echo "La connexion au serveur MySQL n'a pas abouti : " . mysqli_connect_error();
    }
?>