<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Ajout d'un train</h1>
    </div>
    <form class='container' method='POST' action='ajouter_train.php'>
      <div class='form-group'>
        <label for='Seleciton_t_train'>Nom de la gare</label>
        <select class='form-control' id='Selection_t_train' name='Selection_t_train'>
          <option value="0">Aucune</option>
          <?php
            include_once '../../lib/dbconnect.php';
            //Requete des types de trains
            $sql = "SELECT type_train.nom FROM type_train";
            $result = $connexion->prepare($sql);
            $result->execute();

            while ($row=$result->fetch(PDO::FETCH_ASSOC)){
              echo "<option  value=".$row['nom'].">";
              echo $row['nom'];
              echo "</option>";
            }
            $connexion=null;
          ?>
          </select>
        </div>
        <div class="form-group">
          <label for="Numero_train">Numero du train</label>
          <input type="numero" class="form-control" name="Numero_train" placeholder="0">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le train</button>
        <a href='../admin.html' class='btn btn-secondary'>Retour au menu principal administrateur</a>
      </form>
  </body>
</html>
