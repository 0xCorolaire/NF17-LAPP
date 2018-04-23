<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Gérer les trains</h1>
    </div>
    <!-- <div class='row'>
      <div class='col-5 offset-1'> -->
        <h3 class="float-left">Liste des trains</h3>
      <!-- </div>
    </div> -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Numéro du train</th>
          <th>Type de train</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php
        include_once '../../lib/dbconnect.php';

        $sql = "SELECT * FROM train ORDER BY train.numero_train";
        $result = $connexion->prepare($sql);
        $result->execute();
        while ($row=$result->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>
                  <td>".$row['numero_train']."</td>
                  <td>".$row['fk_type']."</td>
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
  <script src="train.js"></script>
</body>
</html>
