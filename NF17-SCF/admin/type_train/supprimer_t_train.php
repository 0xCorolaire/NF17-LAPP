<?php

include_once '../../lib/dbconnect.php';

//Déclaration des variables
$nom = $_POST['nom'];

//Suppression dans la BDD
$sql = "DELETE FROM train WHERE train.fk_type='$nom'";
$result = $connexion->prepare($sql);
$result->execute();

$sql = "DELETE FROM type_train WHERE type_train.nom='$nom'";
$result = $connexion->prepare($sql);
$result->execute();
$connexion=null;
?>
