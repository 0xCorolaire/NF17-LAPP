<?php
include_once '../../lib/dbconnect.php';
$idc = $_POST['id_cal'];
$idt = $_POST['id_train'];
$sql = "DELETE FROM programmation WHERE fk_calendrier='".$idc."' AND fk_train ='".$idt."';";
$result = $connexion->prepare($sql);
$result->execute();
?>
