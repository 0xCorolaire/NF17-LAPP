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
      <h1 class="display-1">Ajout d'un calendrier</h1>
    </div>
    <form class='container' method='POST' action='ajouter_calendrier.php'>
      <div class="form-group">
        <label for="datedebut">Date début</label>
        <input type="date" class="form-control" name="datedebut">
      </div>
      <div class="form-group">
        <label for="datefin">Date fin</label>
        <input type="date" class="form-control" name="datefin">
      </div>
      <div class="form-group">
        <label for="heure">Heure</label>
        <input type="time" class="form-control" name="heure">
      </div>
      <div class="form-group">
        <label for="prix">Prix</label>
        <input type="number" min=0 class="form-control" name="prix">
      </div>
      <div class="row" style="margin-bottom:30px;">
        <div class="col-md-1 col-offset-md-1">
          <label for="lundi">Lundi</label>
          <input type="checkbox" class="form-control" name="lundi">
        </div>
        <div class="col-md-1">
          <label for="mardi">Mardi</label>
          <input type="checkbox" class="form-control" name="mardi">
        </div>
        <div class="col-md-1">
          <label for="mercredi">Mercredi</label>
          <input type="checkbox" class="form-control" name="mercredi">
        </div>
        <div class="col-md-1">
          <label for="jeudi">Jeudi</label>
          <input type="checkbox" class="form-control" name="jeudi">
        </div>
        <div class="col-md-1">
          <label for="vendredi">Vendredi</label>
          <input type="checkbox" class="form-control" name="vendredi">
        </div>
        <div class="col-md-1">
          <label for="samedi">Samedi</label>
          <input type="checkbox" class="form-control" name="samedi">
        </div>
        <div class="col-md-1">
          <label for="dimanche">Dimanche</label>
          <input type="checkbox" class="form-control" name="dimanche">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter le lieu</button>
      <a href='../admin.html' class='btn btn-secondary'>Retour au menu principal administrateur</a>

    </form>
  </body>
</html>
