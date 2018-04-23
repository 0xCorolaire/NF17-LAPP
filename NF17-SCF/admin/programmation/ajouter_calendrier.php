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
          $sql = "INSERT INTO `calendrier`(`date_debut`, `date_fin`, `lundi`, `mardi`, `mercredi`, `jeudi`, `vendredi`, `samedi`, `dimanche`, `heure`, `prix`)
            VALUES ('$datedebut', '$datefin', '$lundi', '$mardi', '$mercredi', '$jeudi', '$vendredi', '$samedi', '$dimanche', '$heure', '$prix')";
          $result = $connexion->prepare($sql);
          $result->execute();
          if(isset( $_POST['id_train'])){
            $id_train = $_POST['id_train'];
            echo  $_POST['id_train'];
            $id = $connexion->lastInsertId();
            $inserProg = $connexion->prepare("INSERT INTO `programmation`(`fk_calendrier`, `fk_train`) VALUES (".$id.",".$id_train.");");
            $inserProg->execute();
          }
          echo "<div class='container text-center'>
                  <h1 class='display-1'>Vous avez ajouté le calendrier</h1>
                </div>
                <p>Vous venez d'ajouter un calendrier !</p>
                <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>
                <a href='ajout_calendrier.php' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Ajouter un autre calendrier</button></a>";
      }
      $connexion=null;
     ?>

  </body>
</html>
