<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html
    ; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <?php
      include_once '../../lib/dbconnect.php';

      //Déclaration des variables
      $verif=true;
      $heure_arriv=$_POST['heurear'];
      $heure_depar=$_POST['heurede'];
      $train=$_POST['statictrain'];
      $gare=$_POST['idgare'];
      $ordre=$_POST['staticordre'];

      //Validité
      if($heure_arriv>$heure_depar){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Vous avez rentré une heure de départ de l'arrêt inférieure à celle d'arrivée.</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='gerer_arret.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Modifier un autre arrêt</button></a>";
        echo "<a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }

      //Implémentation dans la BDD
      if($verif){
        $sql = "UPDATE arret SET heure_arrivee='$heure_arriv', heure_depart='$heure_depar' WHERE arret.fk_train='$train' AND arret.fk_gare='$gare' AND arret.ordre='$ordre'";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous venez de modifier l'arrêt </h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous avez bien modifié l'arrêt !</p>";
        echo "</div>
        <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='gerer_arret.php' class='btn btn-secondary btn-lg btn-block'>Revenir a la gestion des arrêts</a>";
      }
    $connexion=null;
    ?>
  </body>
</html>
