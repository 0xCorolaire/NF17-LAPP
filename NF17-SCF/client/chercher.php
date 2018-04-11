<?php
	session_start();
?>
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

include 'menu.php';

$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	
$gare_depart_existe="SELECT id_gare from gare WHERE nom='".$_POST['gare_depart']."';";
$results = $connexion->prepare($gare_depart_existe);
$results->execute();
$row1 = $results->fetch(PDO::FETCH_ASSOC);
$gare_depart_existe=$row1['id_gare'];


$gare_arrivee_existe="SELECT id_gare from gare WHERE nom='".$_POST['gare_arrivee']."';";
$results2 = $connexion->prepare($gare_arrivee_existe);
$results2->execute();
$row2 = $results2->fetch(PDO::FETCH_ASSOC);
$gare_arrivee_existe=$row2['id_gare'];


if($_POST['partir']=='maintenant'){
	$date="er";
	$heure="233";
}
else{
	$date=$_POST[''];
	$heure=$_POST[''];
}






//////////////////// Le formulaire est correctement rempli ////////////////////

if(  (!empty($_POST['gare_depart']))&&(!empty($_POST['gare_arrivee']))&&(!empty($date))&&(!empty($heure))&&$gare_depart_existe&&$gare_arrivee_existe&&($_POST['gare_depart']!=$_POST['gare_arrivee']) ){		
    
include 'format_donnees.php';

$billet=0;


	$gare_depart=$_POST['gare_depart'];
	$gare_arrivee=$_POST['gare_arrivee'];;

	$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	

	$stmt = $connexion->prepare('SELECT id_gare FROM gare WHERE nom=:nom');
	$stmt->bindValue(':nom', $gare_depart, PDO::PARAM_INT);
	$stmt->execute();
	$id_gare_depart=$stmt->fetch(PDO::FETCH_ASSOC)['id_gare'];

	$stmt->bindValue(':nom', $gare_arrivee, PDO::PARAM_INT);
	$stmt->execute();
	$id_gare_arrivee=$stmt->fetch(PDO::FETCH_ASSOC)['id_gare'];


//////////////////////////////////////// TRAINS AVEC CORRESPONDANCE ////////////////////////////////////////
	$train_passant_par_dep="SELECT fk_train from arret WHERE fk_gare='".$id_gare_depart."';";
	$resultset3 = $connexion->prepare($train_passant_par_dep);
	$resultset3->execute();

	while ($row3 = $resultset3->fetch(PDO::FETCH_ASSOC)){
		$ordre_dep="SELECT ordre, heure_depart from arret WHERE fk_train='".$row3['fk_train']."' AND fk_gare='".$id_gare_depart."';";
 		$resultset4 = $connexion->prepare($ordre_dep);
		$resultset4->execute();
		$row4 = $resultset4->fetch(PDO::FETCH_ASSOC);
		$arret_train_passant_gare_depart="SELECT arret.fk_gare, arret.fk_train,arret.heure_arrivee from arret where fk_train='".$row3['fk_train']."' AND ordre>'".$row4['ordre']."';";
		$resultset5 = $connexion->prepare($arret_train_passant_gare_depart);
		$resultset5->execute();
		while ($row5 = $resultset5->fetch(PDO::FETCH_ASSOC)){ 
			$train_passant_par_arr="SELECT fk_train from arret WHERE fk_gare='".$id_gare_arrivee."';";
 			$resultset6 = $connexion->prepare($train_passant_par_arr);
			$resultset6->execute();
			while ($row6 = $resultset6->fetch(PDO::FETCH_ASSOC)){
				$ordre_arr="SELECT ordre, heure_arrivee from arret WHERE fk_train='".$row6['fk_train']."' AND fk_gare='".$id_gare_arrivee."';";
 				$resultset9 = $connexion->prepare($ordre_arr);
				$resultset9->execute();
				$row9 = $resultset9->fetch(PDO::FETCH_ASSOC);
				$arret_train_passant_gare_arrivee="SELECT arret.fk_gare, arret.fk_train,arret.heure_depart from arret where fk_train='".$row6['fk_train']."' AND ordre<'".$row9['ordre']."';";
				$resultset7 = $connexion->prepare($arret_train_passant_gare_arrivee);
				$resultset7->execute();	
				while ($row7 = $resultset7->fetch(PDO::FETCH_ASSOC)){
					if (($row5['fk_gare'] == $row7['fk_gare']) &&  ($row5['heure_arrivee']<$row7['heure_depart'])){
						echo "<div class='historique_billet'>";
						$billet++;
						$gare_correspondance="SELECT gare.nom, arret.heure_depart, arret.heure_arrivee FROM gare, arret WHERE arret.fk_gare='".$row5['fk_gare']."' AND gare.id_gare='".$row5['fk_gare']."';";
						$resultset8 = $connexion->prepare($gare_correspondance);
						$resultset8->execute();	
						$row8 = $resultset8->fetch(PDO::FETCH_ASSOC);
						$date="1998/01/01";
						if($row3['fk_train']==$row6['fk_train']){  // train direct

							// on souhaite récupérer le type du train 
							$id_train=$row3['fk_train'];
							$type="SELECT type_train.nom from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$id_train.";";
 							$resultset93= $connexion->prepare($type);
							$resultset93->execute();
							$row93 = $resultset93->fetch(PDO::FETCH_ASSOC);
							$type=$row93['nom'];

							date_default_timezone_set('Europe/Paris');
							$temps_billet=gmdate('H:i',strtotime($row9['heure_arrivee'])-strtotime($row4['heure_depart']));
							echo "<div class='historique_date_jour_billet'>";
         					echo format_date_jour_billet("1998/01/01");
      						echo "</div>";
							echo "<div class='historique_date_billet'>";
         					echo format_date_billet("1998/01/01");
      						echo "</div>";
						    echo "<div class='historique_heure_depart_billet'>";
						    echo format_heure($row4['heure_depart']);
						    echo "</div>";
						    echo "<div class='historique_depart_billet'>";
						    echo $gare_depart;
						    echo "</div>";
						    echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";
						    
						    echo "<div class='historique_heure_arrivee_billet'>".format_heure($row9['heure_arrivee'])."</div>";
      						echo "<div class='historique_arrivee_billet'>".$gare_arrivee."</div>";

      
							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row4['heure_depart'];
								echo "</div>";
								echo "<div class='historique_gare_depart'>";
								echo $gare_depart;
								echo "</div>";
								echo "<div class='historique_heure_arrivee'>";
								echo $row9['heure_arrivee'];
								echo "</div>";
								echo "<div class='historique_gare_arrivee'>";
         						echo $gare_arrivee;
      							echo "</div>";
      							echo "<img src='logo.png' class='historique_logo_train'>";
								echo "<div class='historique_train'>";
        		 				echo $type." n°".$row3['fk_train'];
      							echo "</div>";
      						
							echo "</div>";

							$classe1_dispo="SELECT type_train.premiere_classe from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$id_train.";";
 							$resultset91= $connexion->prepare($classe1_dispo);
							$resultset91->execute();
							$row91 = $resultset91->fetch(PDO::FETCH_ASSOC);
							$premiere_classe_dispo=$row91['premiere_classe'];

							echo "<form method='post' action='reservation.php'><input type='hidden' name='correspondance' value='0'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row4['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_arr' value='".$row9['heure_arrivee']."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='submit' class='bouton_reserver_billet_seconde' value='2nd'></form>";
      						if($premiere_classe_dispo)
      							echo "<form method='post' action='reservation.php'><input type='hidden' name='correspondance' value='0'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row4['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_arr' value='".$row9['heure_arrivee']."'><input type='hidden' name='classe' value='1'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='submit' class='bouton_reserver_billet_premiere' value='1ere'></form>";
						    
							}
						else{  // train avec correspondance 


							$id_train1=$row3['fk_train'];
							$type="SELECT type_train.nom from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$id_train1.";";
 							$resultset93= $connexion->prepare($type);
							$resultset93->execute();
							$row93 = $resultset93->fetch(PDO::FETCH_ASSOC);
							$type_train1=$row93['nom'];

							$id_train2=$row6['fk_train'];
							$type2="SELECT type_train.nom from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$id_train2.";";
 							$resultset94= $connexion->prepare($type2);
							$resultset94->execute();
							$row94 = $resultset94->fetch(PDO::FETCH_ASSOC);
							$type_train2=$row94['nom'];


							$classe1_dispo_train1="SELECT type_train.premiere_classe from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$id_train1.";";
 							$resultset91= $connexion->prepare($classe1_dispo_train1);
							$resultset91->execute();
							$row91 = $resultset91->fetch(PDO::FETCH_ASSOC);
							$premiere_classe_dispo_train1=$row91['premiere_classe'];

							$classe1_dispo_train2="SELECT type_train.premiere_classe from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$id_train2.";";
 							$resultset92= $connexion->prepare($classe1_dispo_train2);
							$resultset92->execute();
							$row92 = $resultset92->fetch(PDO::FETCH_ASSOC);
							$premiere_classe_dispo_train2=$row92['premiere_classe'];


							date_default_timezone_set('Europe/Paris');
							$temps_billet=gmdate('H:i',strtotime($row9['heure_arrivee'])-strtotime($row4['heure_depart']));
							echo "<div class='historique_date_jour_billet'>";
         					echo format_date_jour_billet($date);
      						echo "</div>";
							echo "<div class='historique_date_billet'>";
         					echo format_date_billet($date);
      						echo "</div>";
						    echo "<div class='historique_heure_depart_billet'>";
						    echo format_heure($row4['heure_depart']);
						    echo "</div>";
						    echo "<div class='historique_depart_billet'>";
						    echo $gare_depart;
						    echo "</div>";
						    echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";

						    echo "<div class='historique_heure_arrivee_billet'>".format_heure($row9['heure_arrivee'])."</div>";
      						echo "<div class='historique_arrivee_billet'>".$gare_arrivee."</div>";


							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row4['heure_depart'];
								echo "</div>";
								echo "<div class='historique_gare_depart'>";
								echo $gare_depart;
								echo "</div>";

								echo "<div class='historique_heure_arrivee'>";
								echo $row5['heure_arrivee'];
								echo "</div>";
								echo "<div class='historique_gare_arrivee'>";
         						echo $row8['nom'];
      							echo "</div>";
      							echo "<img src='logo.png' class='historique_logo_train'>";
      							echo "<div class='historique_train'>";
        		 				echo $type_train1." n°".$row3['fk_train'];
      							echo "</div>";
							echo "</div>";
							

							echo "<div class='chercher_historique_trajet'>";
								echo "<div class='historique_heure_depart'>";
								echo $row8['heure_depart'];
								echo "</div>";
								echo "<div class='historique_gare_depart'>";
								echo $row8['nom'];
								echo "</div>";
								
								echo "<div class='historique_heure_arrivee'>";
								echo $row9['heure_arrivee'];
								echo "</div>";
								echo "<div class='historique_gare_arrivee'>";
         						echo $gare_arrivee;
      							echo "</div>";
      							echo "<img src='logo.png' class='historique_logo_train'>";
      							echo "<div class='historique_train'>";
        		 				echo $type_train2." n°".$row6['fk_train'];
      							echo "</div>";
							echo "</div>";
						echo "<form method='post' action='reservation.php'><input type='hidden' name='correspondance' value='1'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$row8['nom']."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row4['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_mil1' value='".$row5['heure_arrivee']."'><input type='hidden' name='heure_mil2' value='".$row8['heure_depart']."'><input type='hidden' name='heure_arr' value='".$row9['heure_arrivee']."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='hidden' name='train2' value='".$row6['fk_train']."'><input type='submit' class='bouton_reserver_billet_seconde' value='2nd'></form>";
						if($premiere_classe_dispo_train1 && $premiere_classe_dispo_train2)
							echo "<form method='post' action='reservation.php'><input type='hidden' name='correspondance' value='1'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$row8['nom']."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$row4['heure_depart']."'><input type='hidden' name='date_dep' value='".$date."'><input type='hidden' name='heure_mil1' value='".$row5['heure_arrivee']."'><input type='hidden' name='heure_mil2' value='".$row8['heure_depart']."'><input type='hidden' name='heure_arr' value='".$row9['heure_arrivee']."'><input type='hidden' name='classe' value='1'><input type='hidden' name='train1' value='".$row3['fk_train']."'><input type='hidden' name='train2' value='".$row6['fk_train']."'><input type='submit' class='bouton_reserver_billet_premiere' value='1ere'></form>";
						}
						echo "</div>";
					}
				}
				//mysqli_data_seek($resultset7,0);
			}
			//mysqli_data_seek($resultset6,0);
		}
		//mysqli_data_seek($resultset5,0);
	}
//////////////////////////////////////// TRAINS AVEC CORRESPONDANCE ////////////////////////////////////////




if(!$billet)
	echo "Désolé, aucun résultat ne répond à votre recherche.";
$connexion=null;
}




else{		//////////////////// Le formulaire est pas bien rempli ////////////////////
$connexion=null;

$gare_depart="";
$gare_arrivee="";	

if($gare_depart_existe)
	$gare_depart = htmlspecialchars($_POST["gare_depart"],ENT_QUOTES);
if($gare_arrivee_existe)
	$gare_arrivee = htmlspecialchars($_POST["gare_arrivee"],ENT_QUOTES);

	echo "<img src='background.jpg' class='fond'>
	<form class='recherche' action='chercher.php' method='post' id='form'>
		<div class='titre_recherche'>Chercher un trajet</div>
		<div class='recherche_trait'></div>
		<input id='tags1' type='text' name='gare_depart' class='gare_depart' placeholder='Gare de départ' required value='".$gare_depart."'>
		<img onclick='echanger_gare()' src='fleche.png' class='fleche'>
		<input id='tags2' type='text' name='gare_arrivee' class='gare_arrivee' placeholder='Gare d&apos;arrivée' value='".$gare_arrivee."'>
		<input onclick='affichage_champ_date_heure()' type='radio' name='partir' value='maintenant' class='radio_partir_maintenant' id='radio_partir_maintenant' checked>
		<div class='partir_maintenant'>Partir maintenant</div>
		<input onclick='affichage_champ_date_heure()' type='radio' name='partir' value='partir' class='radio_partir' id='radio_partir'>
		<div class='partir'>Partir à</div>
		<input onclick='affichage_champ_date_heure()' type='radio' name='partir' value='arriver' class='radio_arrivee' id='radio_arrivee'>
		<div class='arrivee'>Arrivée à</div>
		<input type='date' name='date' class='date' id='datepicker' maxlength='10' placeholder=''>
		<input type='date' name='heure' class='heure' maxlength='10' placeholder='' id='heure'>
		<input type='submit' class='chercher' value='Chercher'>
	</form>
	<script>
		$( '#datepicker' ).datepicker({dateFormat: 'yy-mm-dd'});
	</script>";

}


?>
</body>
</html>