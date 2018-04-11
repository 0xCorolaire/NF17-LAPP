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
      //variables
      $gare = $_POST["Selection_Gare"];
      $nom = $_POST["Nom_Lieu"];
      $adresse = $_POST["Adresse_Lieu"];
      $telephone = $_POST["Telephone_Lieu"];
      $type = $_POST["Type_Lieu"];

      if(empty($nom)||empty($adresse)||empty($telephone)||empty($type)||$gare == 0){
        echo "<div class='container text-center'>
                <h1 class='display-1'>Erreur !</h1>
              </div>
              <div class='alert alert-danger' role='alert'>
                <p>Vous avez oublié de remplir un champ</p>
              </div>
              <a href='ajout_lieu.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau le lieu</button></a>
              <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }else {
        $sql = "INSERT INTO `lieu_interet`(`nom_lt`, `adresse_lt`, `telephone_lt`, `type_lieu`, `fk_gare`) VALUES ('$nom', '$adresse', '$telephone', '$type', $gare)";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>
                <h1 class='display-1'>Vous avez ajouté le lieu d'intérêt</h1>
              </div>
              <p>Vous venez d'ajouter un lieu d'intérêt !</p>
              <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>
              <a href='ajout_lieu.php' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Ajouter un autre lieu </button></a>";
      }
      $connexion=null;
     ?>

  </body>
</html>
