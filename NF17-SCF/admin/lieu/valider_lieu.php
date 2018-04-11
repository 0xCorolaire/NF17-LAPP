<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>

    <?php
    include_once '../../lib/dbconnect.php';

    //Déclaration des variables
    $nom = $_POST["nom"];
    $nom_base = $_POST["nom_base"];
    $adresse = $_POST["adresse"];
    $adresse_base = $_POST["adresse_base"];
    $telephone = $_POST["telephone"];
    $type = $_POST["type"];
    $gare = $_POST["gare"];

    // echo "nom : $nom, adresse: $adresse, tel: $telephone, type:$type, gare:$gare";

    //Test de la validité
    if(empty($nom)||empty($adresse)||empty($telephone)||empty($type)||empty($gare)){
      echo "<div class='container text-center'>
              <h1 class='display-1'>Erreur !</h1>
            </div>
            <div class='alert alert-danger container' role='alert'>
              <p class='mx-auto px-auto'>Vous avez oublié de remplir un champ</p>
            </div>
            <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
            <a href='consulter_lieux.php' class='btn btn-secondary btn-lg btn-block'>Revenir a la gestion des lieux</a>";
    }else {

      //Insertion dans la BDD
      $sql = "UPDATE lieu_interet SET nom_lt='$nom', adresse_lt='$adresse', telephone_lt='$telephone', type_lieu='$type', fk_gare=$gare WHERE nom_lt='$nom_base' AND adresse_lt = '$adresse_base';";
      $result = $connexion->prepare($sql);
      $result->execute();
      echo "<div class='container text-center'>
              <h1 class='display-1'>Vous venez de modifier un lieu</h1>
            </div>
            <div class='alert alert-success container' role='alert'>
              <p>Vous avez bien modifié le lieu!</p>
            </div>
            <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
            <a href='consulter_lieux.php' class='btn btn-secondary btn-lg btn-block'>Gérer les lieux</a>";

    }


    $connexion = null;
    ?>
  </body>
</html>
