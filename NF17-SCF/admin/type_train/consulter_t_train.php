<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Gérer les types de train</h1>
    </div>
    <!-- <div class='row'> -->
      <!-- <div class='col-5 offset-1'> -->
        <h3 class="float-left">Liste des types</h3>
      <!-- </div> -->
    <!-- </div> -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Nom type</th>
          <th>Nombre de places</th>
          <th>Places en 1ère classe</th>
          <th>Vitesse</th>
        </tr>
      </thead>
      <tbody>

        <?php
        include_once '../../lib/dbconnect.php';

        $sql = "SELECT * FROM type_train ORDER BY nom";
        $result = $connexion->prepare($sql);
        $result->execute();
        while ($row=$result->fetch(PDO::FETCH_ASSOC)){
          echo "<tr>
                  <td>".$row['nom']."</td>
                  <td>".$row['nb_places']."</td>
                  <td>".$row['premiere_classe']."</td>
                  <td>".$row['vitesse']."</td>
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
    <script src="type_train.js"></script>
  </body>
</html>
