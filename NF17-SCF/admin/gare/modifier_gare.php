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
    <div class="container text-center">
      <h1 class="display-1">Modifiez la gare</h1>
    </div>
    <?php
      include_once '../../lib/dbconnect.php';

      //Déclaration des variables
      $gare = $_GET['id'];

      $sql = "SELECT gare.nom, gare.ville, gare.adresse, gare.zone_horaire FROM gare WHERE gare.id_gare=$gare";
      $result = $connexion->prepare($sql);
      $result->execute();

      //Création du tableau pour récupérer les infos
      $row = $result->fetch(PDO::FETCH_ASSOC);

      //nom de la gare
      echo "<form class='container' method='POST' action='valider_gare.php'>";
      echo  "<div class='form-group'>";
      echo "<label for='Nom_Gare'>Nom de la gare</label>";
      echo "<input type='text' class='form-control' id='Nom_Gare' name='Nom_Gare' value='".$row['nom']."'>";
      echo "</div>";
      //ville gare
      echo  "<div class='form-group'>";
      echo "<label for='Ville_Gare'>Ville de la gare</label>";
      echo "<input type='text' class='form-control' id='Ville_Gare' name='Ville_Gare' value='".$row['ville']."'>";
      echo "</div>";
      //adresse gare
      echo  "<div class='form-group'>";
      echo "<label for='Adresse_Gare'>Adresse de la gare</label>";
      echo "<input type='text' class='form-control' id='Adresse_Gare' name='Adresse_Gare' value='".$row['adresse']."'>";
      echo "</div>";
      //timezone plus tard RIP


      echo "<input type='hidden' class='form-control' id='Nom_Base' name='Nom_Base' value='".$row['nom']."'>";
      echo "<input type='hidden' class='form-control' id='Ville_Base' name='Ville_Base' value='".$row['ville']."'>";
      echo "<input type='hidden' class='form-control' id='Nom_Base' name='Id_Base' value='$gare'>";

      echo "<button type='submit' class='btn btn-warning'>Valider la modification</button>
      <a href='consulter_gares.php' class='btn btn-secondary'>Retour à la gestion des gares</a>";
      echo "</form>";
      $connexion=null;
     ?>
  </body>
</html>
