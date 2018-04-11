<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Gérer des lieux d'intérêt</h1>
    </div>
    <!-- <div class='row'>
      <div class='col-5 offset-1'> -->
        <h3 class="float-left">Liste de lieux d'intérêt</h3>
      <!-- </div>
      <div class='col-5'> -->
        <a href='ajout_lieu.php' class='btn btn-success float-right'>Ajouter un lieu d'intérêt</a>
      <!-- </div>
    </div> -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Adresse</th>
          <th>Téléphone</th>
          <th>Type</th>
          <th>Gare</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php
        include_once '../../lib/dbconnect.php';

        $sql = "SELECT * FROM lieu_interet, gare WHERE gare.id_gare = lieu_interet.fk_gare ORDER BY fk_gare";
        $result = $connexion->prepare($sql);
        $result->execute();
        while ($row=$result->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>
                  <td>".$row['nom_lt']."</td>
                  <td>".$row['adresse_lt']."</td>
                  <td>".$row['telephone_lt']."</td>
                  <td>".$row['type_lieu']."</td>
                  <td>".$row['nom']."</td>
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
    <script src="lieu.js"></script>
  </body>
</html>
