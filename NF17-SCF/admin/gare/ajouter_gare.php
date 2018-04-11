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
      //Pas besoin de rentrer l'id de la gare ( auto increment );

      //Déclaration des variables
      $verif=true;
      $nom = $_POST["Nom_Gare"];
      $ville = $_POST["Ville_Gare"];
      $adresse = $_POST["Adresse_Gare"];
      $TZ = $_POST["TimeZone_Gare"];

      //Si un champs est vide
      if(empty($nom)||empty($ville)||empty($adresse)){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Vous avez oublié de remplir un champ</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='ajout_gare.php' class='btn btn-secondary btn-lg btn-block'>Saisir a nouveau la gare</a>";
      }
      //Si la gare rentrée d'une ville a le même nom qu'un autre gare de cette même ville
      $contrainte = "SELECT * FROM gare";
      $contr = $connexion->prepare($contrainte);
      $contr->execute();
      while($row=$contr->fetch(PDO::FETCH_ASSOC)){
        if(strtolower($nom)==strtolower($row['nom'])&&strtolower($ville)==strtolower($row['ville'])){
          echo "<div class='container text-center'>";
          echo "<h1 class='display-1'>Erreur !</h1>";
          echo "</div>";
          echo "<div class='alert alert-danger container' role='alert'>";
          echo "<p>Le nom de la gare a déjà été rentré pour cette ville</p>";
          echo "</div>";
          $verif=false;
          echo "<a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
          <a href='consulter_gares.php' class='btn btn-secondary btn-lg btn-block'>Saisir a nouveau la gare</a>";
          return;
        }
      }


      //Insertion dans la BDD
      if($verif){
        $sql = "INSERT INTO gare(nom,ville,adresse,zone_horaire) VALUES ('$nom','$ville','$adresse','$TZ')";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous avez ajouté une gare !</h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous venez d'ajouter la gare !</p>";
        echo "</div>
        <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='consulter_gares.php' class='btn btn-secondary btn-lg btn-block'>Revenir a la gestion des gares</a>";
      }

      $connexion=null;
     ?>
     <script src="script.js"></script>
  </body>
</html>
