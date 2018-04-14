<?php
  include_once '../../lib/dbconnect.php';
  //Déclaration variable
  $train = $_GET['id'];

  //Requete du prochain ordre
  $sql = "SELECT MAX(arret.ordre) AS ordree FROM arret WHERE arret.fk_train='$train'";
  $result = $connexion->prepare($sql);
  $result->execute();
  $row = $result->fetch(PDO::FETCH_ASSOC);
  if (isset($row['ordree'])){
    $ordre = $row['ordree']+1;
  }else{
    $ordre = 0;
  }

  echo "<div class='form-group row'>";
  echo "<label for='statictrain' class='col-sm-2 col-form-label'>Numéro de l'arrêt :</label>";
  echo "<div class='col-sm-10'>";
  echo "<input type='text' readonly class='form-control-plaintext' id='ordre' name='ordre' value='".$ordre."'>";
  echo "</div>";
  echo "</div>";

  //Requete des gares disponibles
  $sql = "SELECT gare.id_gare, gare.nom FROM gare LEFT JOIN (SELECT arret.fk_gare FROM arret WHERE arret.fk_train='$train') ar ON gare.id_gare=ar.fk_gare WHERE ar.fk_gare IS NULL";
  $result = $connexion->prepare($sql);
  $result->execute();
  echo "<div class='form-group'>";
  echo "<label for='Selection_gare'>Nom de la gare</label>";
  echo "<select class='form-control' id='Selection_gare' name='Selection_gare'>";
  while ($row=$result->fetch(PDO::FETCH_ASSOC)){
    echo "<option  value=".$row['id_gare'].">";
    echo $row['nom']." - ".$row['id_gare'];
    echo "</option>";
  }
  echo "</select>";
  echo "</div>";

  //Requete des heures
  $sql = "SELECT MAX(arret.heure_arrivee) AS harrivee, MAX(arret.heure_depart) AS hdepart, MAX(arret.ordre) AS ordree FROM arret WHERE arret.fk_train='$train'";
  $result = $connexion->prepare($sql);
  $result->execute();
  $row = $result->fetch(PDO::FETCH_ASSOC);
  if (isset($row['ordree'])){
    $horairearr = $row['harrivee'];
    $horairedep = $row['hdepart'];
  }else{
    $horairearr = '00:00:00';
    $horairedep = '00:00:00';
  }
  //Heure arrivée
  echo  "<div class='form-group'>";
  echo "<label for='heurear'>Heure d'arrivée</label>";
  echo "<input type='time' step='2' class='form-control' id='heurear' name='heurear' min='".$horairearr."' value='".$horairearr."'>";
  echo "</div>";
  //Heure départ
  echo  "<div class='form-group'>";
  echo "<label for='heurede'>Heure de départ</label>";
  echo "<input type='time' step='2' class='form-control' id='heurede' name='heurede' min='".$horairedep."' value='".$horairedep."'>";
  echo "</div>";


?>
