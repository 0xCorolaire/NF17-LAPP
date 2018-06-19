<!DOCTYPE html>
<html>
<head>
   	<title>Société de chemins de fer - Horaires, Trains, Infos</title>
   	<link rel="stylesheet" href="style_client.css" />
   	<link rel="stylesheet" href="../style.css" />
   	<meta charset="utf-8" />
   	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   	<script type="text/javascript">
   function affichage_compte(){
      if (document.getElementById('detail_compte').style.display=="none")
         document.getElementById('detail_compte').style.display="block";
      else
         document.getElementById('detail_compte').style.display="none";
   }
   </script>
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

<?php 

	session_start();

	include 'menu.php';

   	include 'format_donnees.php';

	$num_billet= $_GET['id_billet'];
	$billo=$num_billet;
   	$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	


	$billet="SELECT billet.id_billet, billet.date_depart, trajet.fk_arret_depart, trajet.fk_arret_arrivee, gare.nom, arret.heure_arrivee, gare.id_gare, trajet.id_trajet
         FROM billet
            FULL JOIN voyageur_occasionel
            ON billet.fk_voyocc=voyageur_occasionel.id_voyageur
            FULL JOIN voyageur_regulier
            ON billet.fk_voyreg=voyageur_regulier.id_voyageur
            FULL JOIN trajet
            ON trajet.fk_billet=billet.id_billet
            FULL JOIN arret
            ON arret.id_arret=trajet.fk_arret_arrivee
            FULL JOIN gare
            ON arret.fk_gare=gare.id_gare
         WHERE ((voyageur_occasionel.nom='".$_SESSION['nom']."' AND voyageur_occasionel.prenom='".$_SESSION['prenom']."' AND voyageur_occasionel.numero_tel='".$_SESSION['telephone']."') OR (voyageur_regulier.nom='".$_SESSION['nom']."' AND voyageur_regulier.prenom='".$_SESSION['prenom']."' AND voyageur_regulier.numero_tel='".$_SESSION['telephone']."')) AND billet.id_billet='".$num_billet."'";


     $billet2="SELECT billet.id_billet, billet.date_depart, trajet.fk_arret_depart, trajet.fk_arret_arrivee, gare.nom, arret.heure_depart, gare.id_gare, trajet.id_trajet
         FROM billet
            FULL JOIN voyageur_occasionel
            ON billet.fk_voyocc=voyageur_occasionel.id_voyageur
            FULL JOIN voyageur_regulier
            ON billet.fk_voyreg=voyageur_regulier.id_voyageur
            FULL JOIN trajet
            ON trajet.fk_billet=billet.id_billet
            FULL JOIN arret
            ON arret.id_arret=trajet.fk_arret_depart
            FULL JOIN gare
            ON arret.fk_gare=gare.id_gare
         WHERE ((voyageur_occasionel.nom='".$_SESSION['nom']."' AND voyageur_occasionel.prenom='".$_SESSION['prenom']."' AND voyageur_occasionel.numero_tel='".$_SESSION['telephone']."') OR (voyageur_regulier.nom='".$_SESSION['nom']."' AND voyageur_regulier.prenom='".$_SESSION['prenom']."' AND voyageur_regulier.numero_tel='".$_SESSION['telephone']."')) AND billet.id_billet='".$num_billet."'";


	$resultset1 = $connexion->prepare($billet);
	$resultset1->execute();
	$resultset2 = $connexion->prepare($billet2);
	$resultset2->execute();
	
	$i=1;
	while($row1 = $resultset1->fetch(PDO::FETCH_ASSOC)){
		$row2 = $resultset2->fetch(PDO::FETCH_ASSOC);
		echo $row1['date_depart']."<br>";
		echo $row2['nom']." -> ".$row1['nom']."<br>";
		echo $row2['heure_depart']." --> ".$row1['heure_arrivee']."<br>";
		
		
		








$gare_depart=$row2['nom'];
$gare_arrivee=$row1['nom'];
$partir="maintenant";
$quand_partir="maintenant";
$prix_min=0;
$prix_max=99999;
$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	
$gares_existent="SELECT id_gare from gare WHERE nom='".$gare_depart."' OR nom='".$gare_arrivee."' ;";
$result = $connexion->prepare($gares_existent);
$result->execute();
$gares_existent=0;
while($row = $result->fetch(PDO::FETCH_ASSOC))
	$gares_existent+=1;							// $gares_existent vaut 2 si les 2 gares saisies existent

date_default_timezone_set('Europe/Paris');
$today = getdate();			// today est la date du jour

if($today["mon"]<10)
	$mois="0".$today["mon"];
else
	$mois=$today["mon"];

if($today["mday"]<10)
	$jour="0".$today["mday"];
else
	$jour=$today["mday"];

$aujourdhui=$today["year"]."-".$mois."-".$jour;
$heure_maintenant=$today["hours"].":".$today["minutes"].":00";

if($partir=='maintenant'){
	$date=$aujourdhui;
	$heure=$heure_maintenant;
}
else{
	$date=$_POST['date'];
	$heure=$_POST['heure'];
}


	$billet=0;

	if($quand_partir=='maintenant' || $quand_partir=='partir'){
		$stmt = $connexion->prepare('SELECT id_gare FROM gare WHERE nom=:nom');
		$stmt->bindValue(':nom', $gare_depart, PDO::PARAM_INT);
		$stmt->execute();
		$id_gare_depart=$stmt->fetch(PDO::FETCH_ASSOC)['id_gare'];

		$stmt->bindValue(':nom', $gare_arrivee, PDO::PARAM_INT);
		$stmt->execute();
		$id_gare_arrivee=$stmt->fetch(PDO::FETCH_ASSOC)['id_gare'];

//////////////////////////////////////// TRAINS AVEC CORRESPONDANCE ////////////////////////////////////////

		$jour=strtolower(format_date_jour_billet($date));

		$info_gare_depart ="SELECT DISTINCT arret.fk_train, ordre, heure_depart, fk_type, premiere_classe, max(cast(calendrier.".$jour." AS int)) as jour, max(calendrier.prix) AS prix, max(arret.ordre) AS max_ordre from calendrier, programmation, arret, train, type_train where programmation.fk_calendrier=id_calendrier AND fk_gare='".$id_gare_depart."' AND arret.fk_train=numero_train AND programmation.fk_train=numero_train AND type_train.nom=fk_type AND heure_depart>'".$heure."' GROUP BY arret.fk_train, ordre, heure_depart, fk_type, premiere_classe;";
		$resultset3 = $connexion->prepare($info_gare_depart);
		$resultset3->execute();

		$info_gare_arrivee ="SELECT DISTINCT arret.fk_train, ordre, heure_arrivee, fk_type, premiere_classe, max(cast(calendrier.".$jour." AS int)) as jour, max(calendrier.prix) AS prix, max(arret.ordre) AS max_ordre from calendrier, programmation, arret, train, type_train where programmation.fk_calendrier=id_calendrier AND fk_gare='".$id_gare_arrivee."' AND ordre<>'0' AND arret.fk_train=numero_train AND programmation.fk_train=numero_train AND type_train.nom=fk_type GROUP BY arret.fk_train, ordre, heure_arrivee, fk_type, premiere_classe;";
		$resultset4 = $connexion->prepare($info_gare_arrivee);
		$resultset4->execute();

		while ($row4 = $resultset4->fetch(PDO::FETCH_ASSOC)){
			while ($row3 = $resultset3->fetch(PDO::FETCH_ASSOC)){ 

$temps_billet=gmdate('H:i',strtotime($row4['heure_arrivee'])-strtotime($row3['heure_depart']));
				
if(($row3['fk_train']==$row4['fk_train']) && ($row3['heure_depart']<$row4['heure_arrivee']) &&($row3['jour'])) {    // train direct
	$nb_arret_ligne ="SELECT max(ordre) as nb_arret from arret where fk_train='".$row3['fk_train']."';";
	$resultset42 = $connexion->prepare($nb_arret_ligne);
	$resultset42->execute();
	$row42 = $resultset42->fetch(PDO::FETCH_ASSOC);

		$prix2train1=round((($row4['ordre']-$row3['ordre'])/($row42['nb_arret']))*$row3['prix'], 2);
	$prix1train1=round($prix2train1+($prix2train1*30/100), 2);
	if(($prix2train1<=$prix_max)&&($prix2train1>=$prix_min)){
echo "<div class='chercher_billet'>";
			echo "<div class='detail_billet'>";
							
							echo "<div class='historique_date_billet'>";
         					echo format_date_billet($date);
      						echo "</div>";
						    echo "<div class='chercher_heure_depart_billet'>";
						    echo format_heure($row3['heure_depart']);
						    echo "</div>";
						    echo "<div class='chercher_depart_billet'>";
						    echo $gare_depart;
						    echo "</div>";
						    echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";
						    
						    echo "<div class='chercher_heure_arrivee_billet'>".format_heure($row4['heure_arrivee'])."</div>";
      						echo "<div class='chercher_arrivee_billet'>".$gare_arrivee."</div>";

      
							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row6['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_depart'>";
								echo $gare_depart;
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row4['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_arrivee'>";
         						echo $gare_arrivee;
      							echo "</div>";
      							echo "<img src='logo.png' class='chercher_logo_train'>";
								echo "<div class='chercher_train'>";
        		 				echo $row3['fk_type']." n°".$row3['fk_train'];
      							echo "</div>";
      						
							echo "</div>";
				echo "</div><div class='tarif2'>";			
						echo "<form method='post' action='modifier.php'><input type='hidden' name='traj' value=".$row1['id_trajet']."><input type='hidden' name='bill' value=".$billo."><input type='hidden' name='correspondance' value='0'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row3['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_arr' value='".$row4['heure_arrivee']."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='hidden' name='prix2train1' value='".$prix2train1."'><input type='hidden' name='prix1train1' value='".$prix1train1."'><button type='submit' class='bouton_reserver_billet_seconde'>Meilleur prix<br>".$prix2train1."€</button></form>";
						echo "</div><div class='tarif1'>";
						

				echo "</div>";	
		echo "</div>";
						$billet++;
					}
}
else{
				$info_gare_correspondance1 ="SELECT DISTINCT ordre, gare.nom, arret.fk_gare, arret.heure_arrivee as heure_depart from (SELECT fk_gare from arret where fk_train='".$row3['fk_train']."' AND ordre>'".$row3['ordre']."' INTERSECT SELECT fk_gare from arret where fk_train='".$row4['fk_train']."' AND ordre<'".$row4['ordre']."') AS g, arret, gare WHERE gare.id_gare=arret.fk_gare AND arret.fk_gare=g.fk_gare AND arret.heure_depart>'".$row3['heure_depart']."' AND arret.heure_depart<'".$row4['heure_arrivee']."' AND fk_train='".$row3['fk_train']."' ;";
				$info_gare_correspondance2 ="SELECT DISTINCT ordre, arret.fk_gare, arret.heure_depart as heure_arrivee from (SELECT fk_gare from arret where fk_train='".$row3['fk_train']."' AND ordre>'".$row3['ordre']."' INTERSECT SELECT fk_gare from arret where fk_train='".$row4['fk_train']."' AND ordre<'".$row4['ordre']."') AS g, arret WHERE arret.fk_gare=g.fk_gare AND arret.heure_depart>'".$row3['heure_depart']."' AND arret.heure_depart<'".$row4['heure_arrivee']."' AND fk_train='".$row4['fk_train']."' ;";
						
				$resultset5 = $connexion->prepare($info_gare_correspondance1);
				$resultset5->execute();
				$resultset6 = $connexion->prepare($info_gare_correspondance2);
				$resultset6->execute();
				while($row5 = $resultset5->fetch(PDO::FETCH_ASSOC)){
					$row6 = $resultset6->fetch(PDO::FETCH_ASSOC);
					if(($row5['heure_depart']<$row6['heure_arrivee']) && ($row3['jour']) && ($row4['jour'])){
			
			$nb_arret_ligne1 ="SELECT max(ordre) as nb_arret from arret where fk_train='".$row3['fk_train']."';";
		$resultset42 = $connexion->prepare($nb_arret_ligne1);
	$resultset42->execute();
	$row42 = $resultset42->fetch(PDO::FETCH_ASSOC);

$nb_arret_ligne2 ="SELECT max(ordre) as nb_arret from arret where fk_train='".$row4['fk_train']."';";
		$resultset43 = $connexion->prepare($nb_arret_ligne2);
	$resultset43->execute();
	$row43 = $resultset43->fetch(PDO::FETCH_ASSOC);
	
	$prix_seconde1=round(((($row5['ordre']-$row3['ordre'])/($row42['nb_arret']))*$row3['prix']),2);
	$prix_seconde2=round(((($row4['ordre']-$row6['ordre'])/($row43['nb_arret']))*$row4['prix']), 2);
	$prix_seconde=$prix_seconde1+$prix_seconde2;
	
	$prix_premiere1=round($prix_seconde1+($prix_seconde1*30/100), 2);
	$prix_premiere2=round($prix_seconde2+($prix_seconde2*30/100), 2);
	$prix_premiere=$prix_premiere1+$prix_premiere2;
if(($prix_seconde<=$prix_max)&&($prix_seconde>=$prix_min)){
echo "<div class='chercher_billet'>";
		echo "<div class='detail_billet'>";
							
							echo "<div class='historique_date_billet'>";
         					echo format_date_billet($date);
      						echo "</div>";
						    echo "<div class='chercher_heure_depart_billet'>";
						    echo format_heure($row3['heure_depart']);
						    echo "</div>";
						    echo "<div class='chercher_depart_billet'>";
						    echo $gare_depart;
						    echo "</div>";
						    echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";
						    
						    echo "<div class='chercher_heure_arrivee_billet'>".format_heure($row4['heure_arrivee'])."</div>";
      						echo "<div class='chercher_arrivee_billet'>".$gare_arrivee."</div>";

      
							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row3['heure_depart'];
								echo "</div>";
								echo "<div class='chercher_gare_depart'>";
								echo $gare_depart;
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row5['heure_depart'];
								echo "</div>";
								echo "<div class='chercher_gare_arrivee'>";
         						echo $row5['nom'];
      							echo "</div>";
      							echo "<img src='logo.png' class='chercher_logo_train'>";
								echo "<div class='chercher_train'>";
        		 				echo $row3['fk_type']." n°".$row3['fk_train'];
      							echo "</div>";
      						
							echo "</div>";


							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row6['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_depart'>";
								echo $row5['nom'];
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row4['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_arrivee'>";
         						echo $gare_arrivee;
      							echo "</div>";
      							echo "<img src='logo.png' class='chercher_logo_train'>";
								echo "<div class='chercher_train'>";
        		 				echo $row4['fk_type']." n°".$row4['fk_train'];
      							echo "</div>";
      						
							echo "</div>";
			echo "</div><div class='tarif2'>";						
						echo "<form method='post' action='modifier.php'><input type='hidden' name='traj' value=".$row1['id_trajet']."><input type='hidden' name='bill' value=".$billo."><input type='hidden' name='correspondance' value='1'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$row5['nom']."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row3['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_mil1' value='".$row5['heure_depart']."'><input type='hidden' name='heure_mil2' value='".$row6['heure_arrivee']."'><input type='hidden' name='heure_arr' value='".$row4['heure_arrivee']."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='hidden' name='train2' value='".$row4['fk_train']."'><input type='hidden' name='prix2train1' value='".$prix_seconde1."'><input type='hidden' name='prix1train1' value='".$prix_premiere1."'><input type='hidden' name='prix2train2' value='".$prix_seconde2."'><input type='hidden' name='prix1train2' value='".$prix_premiere2."'><button type='submit' class='bouton_reserver_billet_seconde_correspondance'>Échanger</button></form>";
						echo "</div><div class='tarif1'>";		
						
						echo "</div>";
		echo "</div>";
						$billet++;
}


					}
				}
			}
		}
			$resultset3 = $connexion->prepare($info_gare_depart);
			$resultset3->execute();
		}

		










while($billet<30){
$date=lendemain($date);
$heure="00:00:00";



$jour=strtolower(format_date_jour_billet($date));

		$info_gare_depart ="SELECT DISTINCT arret.fk_train, ordre, heure_depart, fk_type, premiere_classe, max(cast(calendrier.".$jour." AS int)) as jour, max(calendrier.prix) AS prix from calendrier, programmation, arret, train, type_train where programmation.fk_calendrier=id_calendrier AND fk_gare='".$id_gare_depart."' AND arret.fk_train=numero_train AND programmation.fk_train=numero_train AND type_train.nom=fk_type AND heure_depart>'".$heure."' GROUP BY arret.fk_train, ordre, heure_depart, fk_type, premiere_classe;";
		$resultset3 = $connexion->prepare($info_gare_depart);
		$resultset3->execute();

		$info_gare_arrivee ="SELECT DISTINCT arret.fk_train, ordre, heure_arrivee, fk_type, premiere_classe, max(cast(calendrier.".$jour." AS int)) as jour, max(calendrier.prix) AS prix from calendrier, programmation, arret, train, type_train where programmation.fk_calendrier=id_calendrier AND fk_gare='".$id_gare_arrivee."' AND ordre<>'0' AND arret.fk_train=numero_train AND programmation.fk_train=numero_train AND type_train.nom=fk_type GROUP BY arret.fk_train, ordre, heure_arrivee, fk_type, premiere_classe;";
		$resultset4 = $connexion->prepare($info_gare_arrivee);
		$resultset4->execute();
		while ($row4 = $resultset4->fetch(PDO::FETCH_ASSOC)){
			while ($row3 = $resultset3->fetch(PDO::FETCH_ASSOC)){ 

$temps_billet=gmdate('H:i',strtotime($row4['heure_arrivee'])-strtotime($row3['heure_depart']));
if(($row3['fk_train']==$row4['fk_train']) && ($row3['heure_depart']<$row4['heure_arrivee']) &&($row3['jour'])) {
	$nb_arret_ligne ="SELECT max(ordre) as nb_arret from arret where fk_train='".$row3['fk_train']."';";
	$resultset42 = $connexion->prepare($nb_arret_ligne);
	$resultset42->execute();
	$row42 = $resultset42->fetch(PDO::FETCH_ASSOC);

	
	$prix2train1=round((($row4['ordre']-$row3['ordre'])/($row42['nb_arret']))*$row3['prix'], 2);
	$prix1train1=round($prix2train1+($prix2train1*30/100), 2);
	if(($prix2train1<=$prix_max)&&($prix2train1>=$prix_min)){
echo "<div class='chercher_billet'>";
			echo "<div class='detail_billet'>";
							
							echo "<div class='historique_date_billet'>";
         					echo format_date_billet($date);
      						echo "</div>";
						    echo "<div class='chercher_heure_depart_billet'>";
						    echo format_heure($row3['heure_depart']);
						    echo "</div>";
						    echo "<div class='chercher_depart_billet'>";
						    echo $gare_depart;
						    echo "</div>";
						    echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";
						    
						    echo "<div class='chercher_heure_arrivee_billet'>".format_heure($row4['heure_arrivee'])."</div>";
      						echo "<div class='chercher_arrivee_billet'>".$gare_arrivee."</div>";

      
							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row3['heure_depart'];
								echo "</div>";
								echo "<div class='chercher_gare_depart'>";
								echo $gare_depart;
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row4['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_arrivee'>";
         						echo $gare_arrivee;
      							echo "</div>";
      							echo "<img src='logo.png' class='chercher_logo_train'>";
								echo "<div class='chercher_train'>";
        		 				echo $row3['fk_type']." n°".$row3['fk_train'];
      							echo "</div>";
      						
							echo "</div>";
				echo "</div><div class='tarif2'>";			
						echo "<form method='post' action='modifier.php'><input type='hidden' name='traj' value=".$row1['id_trajet']."><input type='hidden' name='bill' value=".$billo."><input type='hidden' name='correspondance' value='0'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row3['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_arr' value='".$row4['heure_arrivee']."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='hidden' name='prix2train1' value='".$prix2train1."'><input type='hidden' name='prix1train1' value='".$prix1train1."'><button type='submit' class='bouton_reserver_billet_seconde'>Échanger</button></form>";
						echo "</div><div class='tarif1'>";
						

				echo "</div>";	
		echo "</div>";
						$billet++;
					}
}
else{
				$info_gare_correspondance1 ="SELECT DISTINCT ordre, gare.nom, arret.fk_gare, arret.heure_arrivee as heure_depart from (SELECT fk_gare from arret where fk_train='".$row3['fk_train']."' AND ordre>'".$row3['ordre']."' INTERSECT SELECT fk_gare from arret where fk_train='".$row4['fk_train']."' AND ordre<'".$row4['ordre']."') AS g, arret, gare WHERE gare.id_gare=arret.fk_gare AND arret.fk_gare=g.fk_gare AND arret.heure_depart>'".$row3['heure_depart']."' AND arret.heure_depart<'".$row4['heure_arrivee']."' AND fk_train='".$row3['fk_train']."' ;";
				$info_gare_correspondance2 ="SELECT DISTINCT ordre, arret.fk_gare, arret.heure_depart as heure_arrivee from (SELECT fk_gare from arret where fk_train='".$row3['fk_train']."' AND ordre>'".$row3['ordre']."' INTERSECT SELECT fk_gare from arret where fk_train='".$row4['fk_train']."' AND ordre<'".$row4['ordre']."') AS g, arret WHERE arret.fk_gare=g.fk_gare AND arret.heure_depart>'".$row3['heure_depart']."' AND arret.heure_depart<'".$row4['heure_arrivee']."' AND fk_train='".$row4['fk_train']."' ;";
						
				$resultset5 = $connexion->prepare($info_gare_correspondance1);
				$resultset5->execute();
				$resultset6 = $connexion->prepare($info_gare_correspondance2);
				$resultset6->execute();
				while($row5 = $resultset5->fetch(PDO::FETCH_ASSOC)){
					$row6 = $resultset6->fetch(PDO::FETCH_ASSOC);
					if(($row5['heure_depart']<$row6['heure_arrivee']) && ($row3['jour']) && ($row4['jour']) ){
						
			$nb_arret_ligne1 ="SELECT max(ordre) as nb_arret from arret where fk_train='".$row3['fk_train']."';";
		$resultset42 = $connexion->prepare($nb_arret_ligne1);
	$resultset42->execute();
	$row42 = $resultset42->fetch(PDO::FETCH_ASSOC);

$nb_arret_ligne2 ="SELECT max(ordre) as nb_arret from arret where fk_train='".$row4['fk_train']."';";
		$resultset43 = $connexion->prepare($nb_arret_ligne2);
	$resultset43->execute();
	$row43 = $resultset43->fetch(PDO::FETCH_ASSOC);
	
	$prix_seconde1=round(((($row5['ordre']-$row3['ordre'])/($row42['nb_arret']))*$row3['prix']),2);
	$prix_seconde2=round(((($row4['ordre']-$row6['ordre'])/($row43['nb_arret']))*$row4['prix']), 2);
	$prix_seconde=$prix_seconde1+$prix_seconde2;
	
	$prix_premiere1=round($prix_seconde1+($prix_seconde1*30/100), 2);
	$prix_premiere2=round($prix_seconde2+($prix_seconde2*30/100), 2);
	$prix_premiere=$prix_premiere1+$prix_premiere2;
if(($prix_seconde<=$prix_max)&&($prix_seconde>=$prix_min)){
echo "<div class='chercher_billet'>";
		echo "<div class='detail_billet'>";
							echo "<div class='historique_date_billet'>";
         					echo format_date_billet($date);
      						echo "</div>";
						    echo "<div class='chercher_heure_depart_billet'>";
						    echo format_heure($row3['heure_depart']);
						    echo "</div>";
						    echo "<div class='chercher_depart_billet'>";
						    echo $gare_depart;
						    echo "</div>";
						    echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";
						    
						    echo "<div class='chercher_heure_arrivee_billet'>".format_heure($row4['heure_arrivee'])."</div>";
      						echo "<div class='chercher_arrivee_billet'>".$gare_arrivee."</div>";

      
							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row3['heure_depart'];
								echo "</div>";
								echo "<div class='chercher_gare_depart'>";
								echo $gare_depart;
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row5['heure_depart'];
								echo "</div>";
								echo "<div class='chercher_gare_arrivee'>";
         						echo $row5['nom'];
      							echo "</div>";
      							echo "<img src='logo.png' class='chercher_logo_train'>";
								echo "<div class='chercher_train'>";
        		 				echo $row3['fk_type']." n°".$row3['fk_train'];
      							echo "</div>";
      						
							echo "</div>";


							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row6['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_depart'>";
								echo $row5['nom'];
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row4['heure_arrivee'];
								echo "</div>";
								echo "<div class='chercher_gare_arrivee'>";
         						echo $gare_arrivee;
      							echo "</div>";
      							echo "<img src='logo.png' class='chercher_logo_train'>";
								echo "<div class='chercher_train'>";
        		 				echo $row4['fk_type']." n°".$row4['fk_train'];
      							echo "</div>";
      						
							echo "</div>";
echo "</div><div class='tarif2'>";
						echo "<form method='post' action='modifier.php'><input type='hidden' name='traj' value=".$row1['id_trajet']."><input type='hidden' name='bill' value=".$billo."><input type='hidden' name='correspondance' value='1'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$row5['nom']."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row3['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_mil1' value='".$row5['heure_depart']."'><input type='hidden' name='heure_mil2' value='".$row6['heure_arrivee']."'><input type='hidden' name='heure_arr' value='".$row4['heure_arrivee']."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='hidden' name='train2' value='".$row4['fk_train']."'><input type='hidden' name='prix2train1' value='".$prix_seconde1."'><input type='hidden' name='prix1train1' value='".$prix_premiere1."'><input type='hidden' name='prix2train2' value='".$prix_seconde2."'><input type='hidden' name='prix1train2' value='".$prix_premiere2."'><button type='submit' class='bouton_reserver_billet_seconde_correspondance'>Échanger</button></form>";
						echo "</div><div class='tarif1'>";		
						
echo "</div>";
		echo "</div>";
						$billet++;

}

					}
				}
			}
		}
			$resultset3 = $connexion->prepare($info_gare_depart);
			$resultset3->execute();
		}






}


if(!$billet)
	echo "Désolé, aucun résultat ne répond à votre recherche.";




		
		$connexion=null;
	}


















	





		



	}
		
		



?>

</body>
</html>