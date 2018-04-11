<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html
    ; charset=UTF-8" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Vous avez ajouté un train</h1>
    </div>
    <?php
      include_once '../lib/dbconnect.php';

      //Déclaration des variables
      $nom = $_POST['Nom_t_train'];
      $nbp = $_POST['Nombre_Place'];
      $nbp1 = $_POST['Nombre_Place_P'];
      $vitesse = $_POST['Vitesse'];
      $verif = true;

      //Validité
      if(empty($nom)||empty($nbp)||empty($vitesse)){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Vous avez oublié de remplir un champs</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='ajout_t_train.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau un type</button></a>";
        echo "<a href='admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }

      if($nbp<$nbp1&&$verif){
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Erreur !</h1>";
        echo "</div>";
        echo "<div class='alert alert-danger container' role='alert'>";
        echo "<p class='mx-auto px-auto'>Impossible d'avoir plus de places en première que le nombre total de places !</p>";
        echo "</div>";
        $verif=false;
        echo "<a href='ajout_t_train.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau un type</button></a>";
        echo "<a href='admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
      }
      if($verif){
        $contrainte = "SELECT * FROM type_train";
        $contr = $connexion->prepare($contrainte);
        $contr->execute();
        while($row=$contr->fetch(PDO::FETCH_ASSOC)){
          if(strtolower($nom)==strtolower($row['nom'])){
            echo "<div class='container text-center'>";
            echo "<h1 class='display-1'>Erreur !</h1>";
            echo "</div>";
            echo "<div class='alert alert-danger container' role='alert'>";
            echo "<p>Le type de train a déjà été rentré !</p>";
            echo "</div>";
            $verif=false;
            echo "<a href='ajout_t_train.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block'>Saisir à nouveau un type</button></a>";
            echo "<a href='admin.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block'>Revenir au menu principal administrateur</button></a>";
            return;
          }
        }
      }

      if($verif){
        $sql = "INSERT INTO type_train(nom,nb_places,premiere_classe,vitesse) VALUES ('$nom',$nbp,$nbp1,$vitesse)";
        $result = $connexion->prepare($sql);
        $result->execute();
        echo "<div class='container text-center'>";
        echo "<h1 class='display-1'>Vous avez ajouté un type de train !</h1>";
        echo "</div>";
        echo "<div class='alert alert-success container' role='alert'>";
        echo "<p>Vous venez d'ajouter le type de train !</p>";
        echo "</div>";
        echo "<a href='admin.html' class='btn-lg white'><button type='button' class='btn btn-primary btn-lg btn-block menu3'>Revenir au menu principal administrateur</button></a>";
        echo "<a href='ajout_t_train.html' class='btn-lg white'><button type='button' class='btn btn-secondary btn-lg btn-block ajout_gare3'>Ajouter un autre type de train</button></a>";
      }
      $connexion=null;
    ?>
  </body>
</html>
