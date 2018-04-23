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
    $id = $_POST["id"];
    $datedebut = $_POST["datedebut"];
    $datefin = $_POST["datefin"];
    $heure = $_POST["heure"];
    $prix = $_POST["prix"];
    $lundi = isset($_POST['lundi']) ? 1 : 0;
    $mardi = isset($_POST['mardi']) ? 1 : 0;
    $mercredi = isset($_POST['mercredi']) ? 1 : 0;
    $jeudi = isset($_POST['jeudi']) ? 1 : 0;
    $vendredi = isset($_POST['vendredi']) ? 1 : 0;
    $samedi = isset($_POST['samedi']) ? 1 : 0;
    $dimanche = isset($_POST['dimanche']) ? 1 : 0;

    //Test de la validité
    if($prix < 0) {
      echo "<div class='container text-center'>
              <h1 class='display-1'>Erreur !</h1>
            </div>
            <div class='alert alert-danger' role='alert'>
              <p>Le prix doit être supérieur à 0</p>
            </div>
            <a href='ajout_calendrier.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau le calendrier</button></a>
            <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
    }else if(new DateTime($datedebut) > new DateTime($datefin)) {
      echo "<div class='container text-center'>
              <h1 class='display-1'>Erreur !</h1>
            </div>
            <div class='alert alert-danger' role='alert'>
              <p>La date de début doit être antérieure à celle de fin</p>
            </div>
            <a href='ajout_calendrier.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau le calendrier</button></a>
            <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
    }else {
      $sql = "UPDATE calendrier SET date_debut='$datedebut', date_fin='$datefin', heure='$heure', prix='$prix', lundi='$lundi', mardi='$mardi', mercredi='$mercredi', jeudi='$jeudi', vendredi='$vendredi', samedi='$samedi', dimanche='$dimanche' WHERE id_calendrier='$id';";
      $result = $connexion->prepare($sql);
      $result->execute();
      echo "<div class='container text-center'>
              <h1 class='display-1'>Vous avez modifié le calendrier</h1>
            </div>
            <p>Vous avez bien modifié le calendrier !</p>
            <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>
            <a href='consulter_programmations.php' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Gerer la programmation</button></a>
            <a href='consulter_calendriers.php' class='btn-lg'><button type='button' class='btn btn-secondary btn-lg btn-block'>Gerer les calendriers</button></a>";
    }


    $connexion = null;
    ?>
  </body>
</html>
