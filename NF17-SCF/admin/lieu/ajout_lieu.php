<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Ajout d'un lieu</h1>
    </div>
    <form class='container' method='POST' action='ajouter_lieu.php'>
      <div class='form-group'>
        <label for='Selection_Gare'>Nom de la gare</label>
        <select class='form-control' id='Selection_Gare' name='Selection_Gare'>
          <option value="0">Aucune</option>
          <?php
            include_once '../../lib/dbconnect.php';
            //Requete des gares
            $sql = "SELECT gare.id_gare, gare.nom, gare.ville FROM gare";
            $result = $connexion->prepare($sql);
            $result->execute();

            while ($row=$result->fetch(PDO::FETCH_ASSOC)){
              echo "<option  value=".$row['id_gare'].">";
              echo $row['nom']." - ".$row['ville'];
              echo "</option>";
            }
            $connexion=null;
           ?>
          </select>
        </div>
        <div class="form-group">
          <label for="Type_Lieu">Type du lieu</label>
          <select class="form-control" name="Type_Lieu">
            <option>Logement</option>
            <option>Transport</option>
          </select>
        </div>
        <div class="form-group">
          <label for="Nom_Lieu">Nom du lieu</label>
          <input type="text" class="form-control" name="Nom_Lieu" placeholder="Nom du lieu">
        </div>
        <div class="form-group">
          <label for="Adresse_Lieu">Adresse du lieu</label>
          <input type="text" class="form-control" name="Adresse_Lieu" placeholder="Adresse du lieu">
        </div>
        <div class="form-group">
          <label for="Telephone_Lieu">Télephone</label>
          <input type="text" class="form-control" name="Telephone_Lieu" placeholder="Téléphone du lieu">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le lieu</button>
        <a href='consulter_lieux.php' class='btn btn-secondary'>Retour à la gestion des lieux</a>

      </form>
  </body>
</html>
