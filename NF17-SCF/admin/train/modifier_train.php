<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html
    ; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Modifiez le train</h1>
    </div>
    <?php
      include_once '../../lib/dbconnect.php';

      //Déclaration des variables
      $numero = $_GET['numero'];
      $sql = "SELECT train.numero_train, train.fk_type FROM train WHERE train.numero_train='$numero'";
      $result = $connexion->prepare($sql);
      $result->execute();

      $r = $connexion->prepare("SELECT type_train.nom FROM type_train");
      $r->execute();

      //Création du tableau pour récupérer les infos
      $row = $result->fetch(PDO::FETCH_ASSOC);

      //numero du train
      echo "<form class='container' method='POST' action='valider_train.php'>";
      echo  "<div class='form-group'>";
      echo "<label for='Num_train'>Numéro du train</label>";
      echo "<input type='numero' class='form-control' id='Num_train' name='Num_train' value='".$row['numero_train']."'>";
      echo "</div>";
      //place dans le train
      echo "<div class='form-group'>
        <label for='gare'>Type de train</label>
        <select class='form-control' name='type_train'>";
        while ($type=$r->fetch(PDO::FETCH_ASSOC)){
            if($type['nom'] == $row['fk_type']) {

              echo "<option selected value=".$type['nom'].">";
            }else {
              echo "<option value=".$type['nom'].">";

            }
            echo $type['nom'];
            echo "</option>";
          }
          echo "</select>
      </div>";
      echo "<input type='hidden' class='form-control' id='Num_base' name='Num_base' value='".$row['numero_train']."''>";
      echo "<button type='submit' class='btn btn-warning'>Valider la modification</button>
      <a href='consulter_train.php' class='btn btn-secondary'>Retour à la gestion des types de train</a>";
      echo "</form>";

      $connexion=null;
    ?>
  </body>
</html>
