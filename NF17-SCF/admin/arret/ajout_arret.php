<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Ajout d'un arrêt</h1>
    </div>
    <form class='container' method='POST' action='ajouter_arret.php'>
      <div class='form-group'>
        <label for='Selection_Train'>Selection du train</label>
        <select class='form-control' id='Selection_Train' name='Selection_Train'>
          <option value="0">Aucun</option>
          <?php
            include_once '../../lib/dbconnect.php';
            //Requete des trains
            $sql = "SELECT train.numero_train, train.fk_type FROM train";
            $result = $connexion->prepare($sql);
            $result->execute();
            while ($row=$result->fetch(PDO::FETCH_ASSOC)){
              echo "<option  value=".$row['numero_train'].">";
              echo $row['numero_train']." - ".$row['fk_type'];
              echo "</option>";
            }
            $connexion=null;
          ?>
          </select>
        </div>
        <div id='Selection_arrêt'>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'arrêt'</button>
        <a href='../admin.html' class='btn btn-secondary'>Retour au menu principal administrateur</a>
      </form>
      <script src="../../lib/jquery-3.3.1.min.js"></script>
      <script src="arret.js"></script>
  </body>
</html>
