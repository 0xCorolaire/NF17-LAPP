<?php

include_once '../../lib/dbconnect.php';

//Déclaration des variables
$numero = $_POST['numero'];

//Suppression dans la BDD
$sql = "DELETE FROM train WHERE train.numero_train='$numero'";
$result = $connexion->prepare($sql);
$result->execute();
$connexion=null;
?>
