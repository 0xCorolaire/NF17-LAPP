<?php
include_once '../../lib/dbconnect.php';
$id = $_POST['id'];

$sql = "DELETE FROM calendrier WHERE id_calendrier='".$id."';";
$result = $connexion->prepare($sql);
$result->execute();
$sql = "DELETE FROM programmation WHERE fk_calendrier='".$id."';";
$result = $connexion->prepare($sql);
$result->execute();
?>
