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
      $train = $_POST["Selection_Train"];


      //Si un champs est vide
      if(empty($train)){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Vous n'avez pas sélectionné de gares</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='ajout_arret.php' class='btn btn-secondary btn-lg btn-block'>Saisir a nouveau l'arrêt</a>";
      }else{
        $gare = $_POST["Selection_gare"];
        $ordre = $_POST["ordre"];
        $harr = $_POST["heurear"];
        $hdep = $_POST["heurede"];
      }

      if($harr>$hdep&&!empty($train)){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Impossible de saisir une heure d'arrivée supérieur à une heure de départ !</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='ajout_arret.php' class='btn btn-secondary btn-lg btn-block'>Saisir a nouveau l'arrêt</a>";
      }

      //Insertion dans la BDD
      if($verif){
        $sql = "INSERT INTO arret(ordre,heure_arrivee,heure_depart,fk_gare,fk_train) VALUES ('$ordre','$harr','$hdep','$gare','$train')";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous avez ajouté un arrêt !</h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous venez d'ajouter l'arrêt !</p>";
        echo "</div>
        <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='ajout_arret.php' class='btn btn-secondary btn-lg btn-block'>Ajouter un autre arrêt</a>";
      }

      $connexion=null;
     ?>
  </body>
</html>
