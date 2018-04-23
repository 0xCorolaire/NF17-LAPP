<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="prog.css">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Gestion des calendriers</h1>
    </div>

    <?php


    include_once '../../lib/dbconnect.php';


      echo '
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Prix</th>
                <th>Heure</th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>
                <th>Dimanche</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>';
            $sql = "SELECT * FROM calendrier order by date_debut";
            $result = $connexion->prepare($sql);
            $result->execute();
            while ($cal=$result->fetch(PDO::FETCH_ASSOC)){

                echo "<tr id=".$cal['id_calendrier'].">
                        <td>".formatDate($cal['date_debut'])."</td>
                        <td>".formatDate($cal['date_fin'])."</td>
                        <td>".$cal['prix']."</td>
                        <td>".$cal['heure']."</td>";
                        echo "<td>";
                        if($cal['lundi']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($cal['mardi']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($cal['mercredi']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($cal['jeudi']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($cal['vendredi']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($cal['samedi']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if($cal['dimanche']) {
                          echo "<img style='height:30px;' src=$yes>";
                        }else {
                          echo "<img style='height:30px;' src=$no>";
                        }
                        echo "</td>";
                        echo "<td>
                                <a class='btn btn-warning modifier'>Modifier</a>
                                <a class='btn btn-danger supprimer'>Supprimer</a>
                              </td>
                            </tr>";
              }

          echo  '</tbody>
          </table>
        </div>
      </div>';

    $connexion=null;

        ?>
      </div>
      <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Retour au menu principal administrateur</a>

    </form>

    <script src="../../lib/jquery-3.3.1.min.js"></script>
    <script src="prog.js"></script>
  </body>
</html>
