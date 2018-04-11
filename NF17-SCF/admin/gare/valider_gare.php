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
      $nom = $_POST["Nom_Gare"];
      $ville = $_POST["Ville_Gare"];
      $adresse = $_POST["Adresse_Gare"];
      $gare = $_POST["Nom_Base"];
      $idgare = $_POST["Id_Base"];
      $gare_v = $_POST["Ville_Base"];

      //Test de la validité
      if(empty($nom)||empty($ville)||empty($adresse)){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Vous avez oublié de remplir un champs</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>";
      }
      $contrainte = "SELECT * FROM gare";
      $contr = $connexion->prepare($contrainte);
      $contr->execute();
      while($row=$contr->fetch(PDO::FETCH_ASSOC)){
        if($nom<>$gare||$ville<>$gare_v){
          if(strtolower($nom)==strtolower($row['nom'])&&strtolower($ville)==strtolower($row['ville'])){
            echo "<div class='container text-center'>";
            echo "<h1 class='display-1'>Erreur !</h1>";
            echo "</div>";
            echo "<div class='alert alert-danger container' role='alert'>";
            echo "<p>Le nom de la gare a déjà été rentré pour cette ville</p>";
            echo "</div>";
            $verif=false;
            echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>";
            return;
          }
        }
      }

      //Implémentation dans la BDD
      if($verif){
        $sql = "UPDATE gare SET nom='$nom', ville='$ville', adresse='$adresse' WHERE gare.id_gare=$idgare";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous venez de modifier une gare</h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous avez bien modifié la gare !</p>";
        echo "</div>
        <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='consulter_gares.php' class='btn btn-secondary btn-lg btn-block'>Revenir a la gestion des gares</a>";
      }


      $connexion = null;
      ?>
    </body>
  </html>
