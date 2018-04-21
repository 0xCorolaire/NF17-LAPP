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
      <h1 class="display-1">Modifiez le type de train</h1>
    </div>
    <?php
      include_once '../../lib/dbconnect.php';

      $nom = $_GET['nom'];
      $sql = "SELECT type_train.nom, type_train.nb_places, type_train.premiere_classe, type_train.vitesse FROM type_train WHERE type_train.nom='$nom'";
      $result = $connexion->prepare($sql);
      $result->execute();

      //Création du tableau pour récupérer les infos
      $row = $result->fetch(PDO::FETCH_ASSOC);

      //nom du type
      echo "<form class='container' method='POST' action='valider_t_train.php'>";
      echo  "<div class='form-group'>";
      echo "<label for='Nom_t_train'>Nom du type de train</label>";
      echo "<input type='text' class='form-control' id='Nom_t_train' name='Nom_t_train' value='".$row['nom']."'>";
      echo "</div>";
      //place dans le train
      echo  "<div class='form-group'>";
      echo "<label for='nbpl'>Nombre de place total dans le train</label>";
      echo "<input type='number' class='form-control' id='nbpl' name='nbpl' value='".$row['nb_places']."'>";
      echo "</div>";
      //place en 1ere
      echo  "<div class='form-group'>";
      echo "<label for='prempl'>Nombre de place en 1ère classe</label>";
      echo "<input type='number' class='form-control' id='prempl' name='prempl' value='".$row['premiere_classe']."'>";
      echo "</div>";
      //vitesse du train
      echo  "<div class='form-group'>";
      echo "<label for='vit'>Vitesse du train</label>";
      echo "<input type='number' class='form-control' id='vit' name='vit' value='".$row['vitesse']."'>";
      echo "</div>";


      echo "<input type='hidden' class='form-control' id='t' name='Nomt_t_base' value='".$row['nom']."'>";

      echo "<button type='submit' class='btn btn-warning'>Valider la modification</button>
      <a href='consulter_t_train.php' class='btn btn-secondary'>Retour à la gestion des types de train</a>";
      echo "</form>";


      $connexion=null;
    ?>
  </body>
</html>
