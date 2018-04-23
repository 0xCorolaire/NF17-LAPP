<?php
  include_once '../../lib/dbconnect.php';
  $idc = $_POST['id_cal'];
  $idt = $_POST['id_train'];

  $sql = "INSERT INTO programmation VALUES (".$idc.",".$idt.");";
  $result = $connexion->prepare($sql);
  $result->execute();

?>
