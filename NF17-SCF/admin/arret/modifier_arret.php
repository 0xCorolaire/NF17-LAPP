<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html
    ; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <body>
    <div class="container text-center">
      <h1 class="display-1">Modifiez l'arrêt</h1>
    </div>
    <form class='container' method='POST' action='valider_arret.php'>
    <?php
      include_once '../../lib/dbconnect.php';

      $idarret = $_GET['id'];
      $sql = "SELECT * FROM arret WHERE arret.id_arret='$idarret'";
      $result = $connexion->prepare($sql);
      $result->execute();

      //Création du tableau pour récupérer les infos
      $row = $result->fetch(PDO::FETCH_ASSOC);
      $sql2 = "SELECT gare.nom FROM gare WHERE gare.id_gare='".$row['fk_gare']."'";
      $result2 = $connexion->prepare($sql2);
      $result2->execute();
      $row2 = $result2->fetch(PDO::FETCH_ASSOC);


      //Info sur l'arret modifié
      //train
      echo "<div class='form-group row'>";
      echo "<label for='statictrain' class='col-sm-2 col-form-label'>Numéro du train :</label>";
      echo "<div class='col-sm-10'>";
      echo "<input type='text' readonly class='form-control-plaintext' id='statictrain' name='statictrain' value='".$row['fk_train']."'>";
      echo "</div>";
      echo "</div>";
      //gare
      echo "<div class='form-group row'>";
      echo "<label for='staticgare' class='col-sm-2 col-form-label'>Nom de la gare :</label>";
      echo "<div class='col-sm-10'>";
      echo "<input type='text' readonly class='form-control-plaintext' id='staticgare' name='staticgare' value='".$row2['nom']."'>";
      echo "</div>";
      echo "</div>";
      //idgare
      echo "<div class='form-group row'>";
      echo "<label for='idgare' class='col-sm-2 col-form-label'>Id de la gare :</label>";
      echo "<div class='col-sm-10'>";
      echo "<input type='text' readonly class='form-control-plaintext' id='idgare' name='idgare' value='".$row['fk_gare']."'>";
      echo "</div>";
      echo "</div>";
      //ordre arret
      echo "<div class='form-group row'>";
      echo "<label for='staticordre' class='col-sm-2 col-form-label'>Arret numéro :</label>";
      echo "<div class='col-sm-10'>";
      echo "<input type='text' readonly class='form-control-plaintext' id='staticordre' name='staticordre' value='".$row['ordre']."'>";
      echo "</div>";
      echo "</div>";


      //Heure arrivée
      echo  "<div class='form-group'>";
      echo "<label for='heurear'>Heure d'arrivée</label>";
      echo "<input type='time' step='2' class='form-control' id='heurear' name='heurear' value='".$row['heure_arrivee']."'>";
      echo "</div>";

      //Heure départ
      echo  "<div class='form-group'>";
      echo "<label for='heurede'>Heure de départ</label>";
      echo "<input type='time' step='2' class='form-control' id='heurede' name='heurede' value='".$row['heure_depart']."'>";
      echo "</div>";

      echo "<input type='hidden' class='form-control' id='t' name='idgare' value='".$row['fk_gare']."'>";

      echo "<button type='submit' class='btn btn-warning'>Valider la modification</button>
      <a href='gerer_arret.php' class='btn btn-secondary'>Retour à la gestion des arrêts</a>";
      echo "</form>";


      $connexion=null;
    ?>
    <script src="../../lib/jquery-3.3.1.min.js"></script>
  </body>
</html>
