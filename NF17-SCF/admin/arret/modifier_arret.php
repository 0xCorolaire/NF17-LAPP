<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html
    ; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Modifiez l'arrêt</h1>
    </div>
    <?php
      include_once '../../lib/dbconnect.php';

      $idarret = $_GET['id'];
      $sql = "SELECT * FROM arret WHERE arret.id_arret='$idarret'";
      $result = $connexion->prepare($sql);
      $result->execute();

      //Création du tableau pour récupérer les infos
      $row = $result->fetch(PDO::FETCH_ASSOC);

      //Heure arrivée
      echo "<div class='well'>
        <div id='datetimepicker3' class='input-append'>
          <input data-format='hh:mm:ss' type='text' name = 'heurea'></input>
          <span class='add-on'>
            <i data-time-icon='icon-time' data-date-icon='icon-calendar'>
            </i>
          </span>
        </div>
      </div>";
      //Heure départ
      echo "<div class='well'>
        <div id='datetimepicker4' class='input-append'>
          <input data-format='hh:mm:ss' type='text' name = 'heured'></input>
          <span class='add-on'>
            <i data-time-icon='icon-time' data-date-icon='icon-calendar'>
            </i>
          </span>
        </div>
      </div>";



    //  echo "<input type='hidden' class='form-control' id='t' name='Nomt_t_base' value='".$row['nom']."'>";

      echo "<button type='submit' class='btn btn-warning'>Valider la modification</button>
      <a href='gerer_arret.php' class='btn btn-secondary'>Retour à la gestion des arrêts</a>";
      echo "</form>";


      $connexion=null;
    ?>
    <script src="../../lib/jquery-3.3.1.min.js"></script>
    <script type="text/javascript"
     src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.2/js/bootstrap.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>
    <script type="text/javascript">
      $(function() {
        $('#datetimepicker3').datetimepicker({
          pickDate: false
        });
      });
    </script>
  </body>
</html>
