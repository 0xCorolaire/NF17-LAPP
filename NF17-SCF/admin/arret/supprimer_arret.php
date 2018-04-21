<?php

include_once '../../lib/dbconnect.php';

//Déclaration des variables
$arret = $_POST['id'];

//Suppression dans la BDD
$sql = "DELETE FROM arret WHERE arret.id_arret='$arret'";
$result = $connexion->prepare($sql);
$result->execute();

$connexion=null;
?>
