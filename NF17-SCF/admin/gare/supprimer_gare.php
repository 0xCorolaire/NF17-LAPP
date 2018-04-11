<?php

include_once '../../lib/dbconnect.php';

//Déclaration des variables
$gare = $_POST['id'];

//Suppression dans la BDD
//Il faudrait peut être supprimer les lieux associés
$sql = "DELETE FROM lieu_interet WHERE fk_gare='$gare'";
$result = $connexion->prepare($sql);
$result->execute();
$sql = "DELETE FROM gare WHERE gare.id_gare='$gare'";
$result = $connexion->prepare($sql);
$result->execute();

$connexion=null;
?>
