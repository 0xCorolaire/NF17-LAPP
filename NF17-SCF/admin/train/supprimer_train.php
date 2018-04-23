<?php

include_once '../../lib/dbconnect.php';

//Déclaration des variables
$numero = $_POST['numero'];

//Suppression dans la BDD
$sql = "DELETE FROM arret WHERE arret.fk_train='$numero'";
$result = $connexion->prepare($sql);
$result->execute();
$sql = "DELETE FROM train WHERE train.numero_train='$numero'";
$result = $connexion->prepare($sql);
$result->execute();
$sql = "DELETE FROM programmation WHERE fk_train='$numero'";
$result = $connexion->prepare($sql);
$result->execute();
$connexion=null;
?>
