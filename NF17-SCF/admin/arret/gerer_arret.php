<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Gérer les arrêts</h1>
    </div>
    <!-- <div class='row'> -->
      <!-- <div class='col-5 offset-1'> -->
        <h3 class="float-left">Liste des arrêts</h3>
      <!-- </div> -->
    <!-- </div> -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID arret</th>
          <th>Ordre</th>
          <th>Heure d'arrivée</th>
          <th>Heure de départ</th>
          <th>Nom de la gare</th>
          <th>Numéro du train</th>
        </tr>
      </thead>
      <tbody>
    <?php
      include_once '../../lib/dbconnect.php';

      $sql = "SELECT * FROM arret ORDER BY arret.fk_train,arret.ordre";
      $result = $connexion->prepare($sql);
      $result->execute();
      while ($row=$result->fetch(PDO::FETCH_ASSOC)){
        echo "<tr>
              <td>".$row['id_arret']."</td>
              <td>".$row['ordre']."</td>
              <td>".$row['heure_arrivee']."</td>
              <td>".$row['heure_depart']."</td>
              <td>".$row['fk_gare']."</td>
              <td>".$row['fk_train']."</td>
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
    <script src="arret.js"></script>
  </body>
</html>
