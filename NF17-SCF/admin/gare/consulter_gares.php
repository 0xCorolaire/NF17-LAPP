<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Gérer des gares</h1>
    </div>
    <!-- <div class='row'> -->
      <!-- <div class='col-5 offset-1'> -->
        <h3 class="float-left">Liste de gares</h3>
      <!-- </div> -->
      <!-- <div class='col-5'> -->
        <a href='ajout_gare.html' class='btn btn-success float-right'>Ajouter une gare</a>
      <!-- </div> -->
    <!-- </div> -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID gare</th>
          <th>Nom</th>
          <th>Ville</th>
          <th>Adresse</th>
          <th>Zone_horaire</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php
        include_once '../../lib/dbconnect.php';

        $sql = "SELECT * FROM gare ORDER BY id_gare";
        $result = $connexion->prepare($sql);
        $result->execute();
        while ($row=$result->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>
                  <td>".$row['id_gare']."</td>
                  <td>".$row['nom']."</td>
                  <td>".$row['ville']."</td>
                  <td>".$row['adresse']."</td>
                  <td>".$row['zone_horaire']."</td>
                  <td>
                    <a class='btn btn-warning modifier'>Modifier</a>
                    <a class='btn btn-danger supprimer'>Supprimer</a>
                  </td>
               </tr>";
        }
        $connexion=null;
        ?>

      </tbody>
    </table>
    <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>
    <script src="../../lib/jquery-3.3.1.min.js"></script>
    <script src="gare.js"></script>
  </body>
</html>
