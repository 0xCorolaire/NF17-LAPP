<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Société De Chemins de Fer Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  </head>
  <body>
    <div class="container text-center">
      <h1 class="display-1">Modification du lieu</h1>
    </div>
    <?php
      include_once '../../lib/dbconnect.php';

      //Déclaration des variables
      $nom = $_GET['nom'];
      $adresse = $_GET['adresse'];

      $r = $connexion->prepare("SELECT gare.id_gare, gare.nom, gare.ville FROM gare");
      $r->execute();

      $sql = "SELECT * FROM lieu_interet WHERE nom_lt='$nom' AND adresse_lt='$adresse';";
      $result = $connexion->prepare($sql);
      $result->execute();

      //Création du tableau pour récupérer les infos
      $lieu = $result->fetch(PDO::FETCH_ASSOC);

      echo "<form class='container' method='POST' action='valider_lieu.php'>
              <div class='form-group'>
                <label for='nom'>Nom du lieu</label>
                <input type='text' class='form-control' name='nom' value='".$lieu['nom_lt']."'>
              </div>
              <div class='form-group'>
                <label for='adresse'>Adresse</label>
                <input type='text' class='form-control' name='adresse' value='".$lieu['adresse_lt']."'>
              </div>
              <div class='form-group'>
                <label for='telephone'>Téléphone</label>
                <input type='text' class='form-control' name='telephone' value='".$lieu['telephone_lt']."'>
              </div>
              <div class='form-group'>
                <label for='type'>Type du lieu</label>
                <select class='form-control' name='type'>
                  <option ".($lieu['type_lieu'] == 'Hotel' ? "selected" :"").">Hotel</option>
                  <option ".($lieu['type_lieu'] == 'Taxi' ? "selected" :"").">Taxi</option>
                </select>
              </div>
              <div class='form-group'>
                <label for='gare'>Nom de la gare</label>
                <select class='form-control' name='gare'>";
                while ($gare=$r->fetch(PDO::FETCH_ASSOC)){
                    if($gare['id_gare'] == $lieu['fk_gare']) {

                      echo "<option selected value=".$gare['id_gare'].">";
                    }else {
                      echo "<option value=".$gare['id_gare'].">";

                    }
                    echo $gare['nom']." - ".$gare['ville'];
                    echo "</option>";
                  }
            echo "</select>
              </div>
              <input type='hidden' name='nom_base' value='".$nom."'>
              <input type='hidden' name='adresse_base' value='".$adresse."'>
              <button type='submit' class='btn btn-success'>Valider la modification</button>
              <a href='consulter_lieux.php' class='btn btn-secondary'>Retour à la gestion des lieux</a>

            </form>";
      $connexion=null;
     ?>
  </body>
</html>
