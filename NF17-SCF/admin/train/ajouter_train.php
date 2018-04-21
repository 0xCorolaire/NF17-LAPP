<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <?php
      include_once '../../lib/dbconnect.php';
      //variables
      $numero = $_POST['Numero_train'];
      $type = $_POST['Selection_t_train'];

      if($type == '0'||empty($numero)){
        echo "<div class='container text-center'>
                <h1 class='display-1'>Erreur !</h1>
              </div>
              <div class='alert alert-danger' role='alert'>
                <p>Vous avez rentré un train incorrect !</p>
              </div>
              <a href='ajout_train.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau le train</button></a>
              <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }else {
        $sql = "INSERT INTO train(numero_train,fk_type) VALUES ($numero,'$type')";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous avez ajouté un train !</h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous venez d'ajouter le train !</p>";
        echo "</div>
              <a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>
              <a href='ajout_train.php' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Ajouter un autre train </button></a>";
      }
      $connexion=null;
     ?>

  </body>
</html>
