<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="prog.css">

  </head>
  <body>
    <?php
      include_once '../../lib/dbconnect.php';

      //Déclaration des variables
      $id = $_GET['id'];
      $r = $connexion->prepare("SELECT * FROM calendrier WHERE id_calendrier=$id");
      $r->execute();


      //Création du tableau pour récupérer les infos
      $cal = $r->fetch(PDO::FETCH_ASSOC);
//       echo $cal['lundi'];
// echo ($cal['lundi'] ? "checked" : "")

      echo "<div class='container text-center'>
              <h1 class='display-1'>Modification du calendrier $id</h1>
              </div>
              <form class='container' method='POST' action='valider_calendrier.php'>
              <div class='form-group'>
                <label for='datedebut'>Date de début</label>
                <input type='date' class='form-control' name='datedebut' value='".$cal['date_debut']."'>
              </div>
              <div class='form-group'>
                <label for='datefin'>Date fin</label>
                <input type='date' class='form-control' name='datefin' value='".$cal['date_fin']."'>
              </div>
              <div class='form-group'>
                <label for='prix'>prix</label>
                <input type='number' class='form-control' name='prix' value='".$cal['prix']."'>
              </div>
              <div class='form-group'>
                <label for='heure'>Heure</label>
                <input type='time' class='form-control' name='heure' value='".$cal['heure']."'>
              </div>

              <label for='lundi'>lundi</label>
              <input type='checkbox' name='lundi' ".($cal['lundi'] ? "checked" : "").">
              <label for='mardi'>mardi</label>
              <input type='checkbox' name='mardi'  ".($cal['mardi'] ? "checked" : "").">
              <label for='mercredi'>mercredi</label>
              <input type='checkbox' name='mercredi'  ".($cal['mercredi'] ? "checked" : "").">
              <label for='jeudi'>jeudi</label>
              <input type='checkbox' name='jeudi'  ".($cal['jeudi'] ? "checked" : "").">
              <label for='vendredi'>vendredi</label>
              <input type='checkbox' name='vendredi'  ".($cal['vendredi'] ? "checked" : "").">
              <label for='samedi'>samedi</label>
              <input type='checkbox' name='samedi'  ".($cal['samedi'] ? "checked" : "").">
              <label for='dimanche'>dimanche</label>
              <input type='checkbox' name='dimanche'  ".($cal['dimanche'] ? "checked" : "").">


              <input type='hidden' name='id' value='".$id."'>
              <button type='submit' class='btn btn-success'>Valider la modification</button>
              <a href='consulter_programmations.php' class='btn btn-secondary'>Retour à la gestion des calendriers</a>

            </form>";
      $connexion=null;
     ?>
  </body>
</html>
