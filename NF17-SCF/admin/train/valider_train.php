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
      $numero = $_POST["Num_train"];
      $type = $_POST["type_train"];
      $numbase = $_POST["Num_base"];

      //Test validité
      if($type == '0'||empty($numero)){
        $verif=false;
        echo "<div class='container text-center'>
                <h1 class='display-1'>Erreur !</h1>
              </div>
              <div class='alert alert-danger' role='alert'>
                <p>Vous avez rentré un train incorrect !</p>
              </div>
              <a href='consulter_train.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Retour à la gestion des trains</button></a>
              <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }
      $contrainte = "SELECT * FROM train";
      $contr = $connexion->prepare($contrainte);
      $contr->execute();
      while($row=$contr->fetch(PDO::FETCH_ASSOC)){
        if($numero<>$numbase){
            if($numero == $row["numero_train"]){
            echo "<div class='container text-center'>";
            echo "<h1 class='display-1'>Erreur !</h1>";
            echo "</div>";
            echo "<div class='alert alert-danger container' role='alert'>";
            echo "<p>Ce numéro de train a déjà été rentré !</p>";
            echo "</div>";
            $verif=false;
            echo "<a href='consulter_train.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Retour à la gestion des trains</button></a>";
            echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>";
            return;
          }
        }
      }

      if($verif){
        $sql = "UPDATE train SET numero_train='$numero', fk_type='$type' WHERE train.numero_train=$numbase";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Succès !</h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous venez de modifier le train !</p>";
        echo "</div>
              <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>
              <a href='consulter_train.php' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Retourner à la gestion des trains </button></a>";
      }
      $connexion=null;
     ?>

  </body>
</html>
