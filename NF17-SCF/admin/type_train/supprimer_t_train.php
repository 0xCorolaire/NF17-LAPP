<?php

include_once '../../lib/dbconnect.php';

//Déclaration des variables
$nom = $_POST['nom'];

//Suppression dans la BDD
$sqll = "SELECT train.numero_train FROM train WHERE train.fk_type='$nom'";
$resultt = $connexion->prepare($sqll);
$resultt->execute();
while ($row=$resultt->fetch(PDO::FETCH_ASSOC)){
  $sql = "DELETE FROM arret WHERE arret.fk_train=".$row['numero_train'];
  $result = $connexion->prepare($sql);
  $result->execute();
}
$sql = "DELETE FROM train WHERE train.fk_type='$nom'";
$result = $connexion->prepare($sql);
$result->execute();

$sql = "DELETE FROM type_train WHERE type_train.nom='$nom'";
$result = $connexion->prepare($sql);
$result->execute();
$connexion=null;
?>
