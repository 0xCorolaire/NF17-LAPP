<?php
include_once '../../lib/dbconnect.php';
$id = explode(';', $_POST['lieu']);

$sql = "DELETE FROM lieu_interet WHERE nom_lt='".$id[0]."' AND adresse_lt ='".$id[1]."';";
$result = $connexion->prepare($sql);
$result->execute();
return "ok !";
?>
