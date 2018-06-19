<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Société de chemins de fer - Horaires, Trains, Infos</title>
	<link rel="stylesheet" href="style.css" />
	<meta charset="utf-8" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<script>
		$( ".date" ).datepicker({
  		dateFormat: "yy-mm-dd"
		});
	</script>

	<script type="text/javascript">
	function affichage_compte(){
		if (document.getElementById('detail_compte').style.display=="none")
			document.getElementById('detail_compte').style.display="block";
		else
			document.getElementById('detail_compte').style.display="none";
	}
	
	function echanger_gare(){
		var gare_depart = document.getElementById("tags1").value;
		var gare_arrivee = document.getElementById("tags2").value;
		
		document.getElementById("tags1").value=gare_arrivee;
		document.getElementById("tags2").value=gare_depart;
	}

	function affichage_champ_date_heure(){

		if (document.getElementById("radio_partir_maintenant").checked){
			document.getElementById('datepicker').style.display="none";
			document.getElementById('heure').style.display="none";
		}
		else{
			document.getElementById('datepicker').style.display="block";
			document.getElementById('heure').style.display="block";
		}
	}

	</script>

	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    var availableTags = [
    <?php
    $connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');  
    $sql = "SELECT gare.nom
        FROM gare;";

     $resultset = $connexion->prepare($sql);
    $resultset->execute();   
    while ($row = $resultset->fetch(PDO::FETCH_ASSOC)){
      echo '"'.$row["nom"].'",';
    }
    $connexion=null;
  
    ?>
   
    ];
    $( "#tags1" ).autocomplete({
      source: availableTags
    });
     $( "#tags2" ).autocomplete({
      source: availableTags
    });
  } );

  </script>

</head>
<body>
	
	<?php include 'menu.php'; ?>
	
	<img src="client/background.jpg" class="fond">
	<form class="recherche" action="client/chercher.php" method="post" id="form">
		<div class="titre_recherche">Chercher un trajet</div>
		<div class="recherche_trait"></div>
		<input id="tags1" type="text" name="gare_depart" class="gare_depart" placeholder="Gare de départ" required>
		<img onclick="echanger_gare()" src="client/fleche.png" class="fleche">
		<input id="tags2" type="text" name="gare_arrivee" class="gare_arrivee" placeholder="Gare d'arrivée" required>
		<input onclick="affichage_champ_date_heure()" type="radio" name="partir" value="maintenant" class="radio_partir_maintenant" id="radio_partir_maintenant" checked>
		<div class="partir_maintenant">Partir maintenant</div>
		<input onclick="affichage_champ_date_heure()" type="radio" name="partir" value="partir" class="radio_partir" id="radio_partir">
		<div class="partir">Partir à</div>
		<input onclick="affichage_champ_date_heure()" type="radio" name="partir" value="arriver" class="radio_arrivee" id="radio_arrivee">
		<div class="arrivee">Arrivée à</div>
		<input type="date" name="date" class="date" id="datepicker" maxlength="10" placeholder="">
		<input type="date" name="heure" class="heure" maxlength="10" placeholder="" id="heure">
		<input type="number" name="prix_min" class="prix_min" placeholder="Prix min" min='0'>
		<input type="number" name="prix_max" class="prix_max" placeholder="Prix max" min='0'>
		<input type="submit" class="chercher" value="Chercher">
	</form>
	<script>
		$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
	</script>
</body>
</html>