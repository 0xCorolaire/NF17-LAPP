<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html
    ; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <?php
      include_once '../../lib/dbconnect.php';

      //Déclaration des variables
      $verif=true;
      $nom = $_POST["Nom_t_train"];
      $nbpl = $_POST["nbpl"];
      $prempl = $_POST["prempl"];
      $vitesse = $_POST["vit"];
      $nombase = $_POST["Nomt_t_base"];

      //Validité
      if(empty($nom)||empty($nbpl)||empty($vitesse)){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Vous avez oublié de remplir un champs</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='consulter_t_train.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Modifier un autre type</button></a>";
        echo "<a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }
      if($nbpl<$prempl&&$verif){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Impossible d'avoir plus de places en première que le nombre total de places !</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='consulter_t_train.php' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Modifier un autre type</button></a>";
        echo "<a href='../admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }


      //Implémentation dans la BDD
      if($verif){
        $sql = "UPDATE type_train SET nom='$nom', nb_places='$nbpl', premiere_classe='$prempl', vitesse=$vitesse WHERE type_train.nom='$nombase'";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous venez de modifier le type de train </h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous avez bien modifié le type de train !</p>";
        echo "</div>
        <a href='../admin.html' class='btn btn-primary btn-lg btn-block'>Revenir au menu principal administrateur</a>
        <a href='consulter_t_train.php' class='btn btn-secondary btn-lg btn-block'>Revenir a la gestion des types de trains</a>";
      }
    $connexion=null;
    ?>
  </body>
</html>
