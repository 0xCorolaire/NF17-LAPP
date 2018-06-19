<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Société de chemins de fer - Horaires, Trains, Infos</title>
   	<link rel="stylesheet" href="client/style_client.css" />
   	<meta charset="utf-8" />
</head>
<body>
<?php
	$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	
	$correspondance=$_POST['correspondance'];


	////////////// Si trajet direct il faut créer 1 billet et 1 trajet //////////////
$billllet=$_POST['billet'];
	if(!$correspondance){
		$gare_depart=$_POST['dep'];
	   	$gare_arrivee=$_POST['arr'];
	   	$heure_depart=$_POST['heure_dep'];
	   	$date_depart=$_POST['date_dep'];
	   	$heure_arrivee=$_POST['heure_arr'];
	   	$classe1=$_POST['classe1']; 
	   	$train1=$_POST['train1'];
	   	if(isset($_POST['assurance']))
	   		$assurance="TRUE";
	   	else
	   		$assurance="FALSE";
	   	$paiement=$_POST['paiement'];
	   	$paiement=strtolower($paiement);
	
	   	$nom=$_SESSION['nom'];
	   	$prenom=$_SESSION['prenom'];
	   	$telephone=$_SESSION['telephone'];

	   	$id_voyageur="SELECT id_voyageur from voyageur_occasionel WHERE nom='".$nom."' AND prenom='".$prenom."' AND numero_tel='".$telephone."';";
	   	$resultset70= $connexion->prepare($id_voyageur);
		$resultset70->execute();
		$row70 = $resultset70->fetch(PDO::FETCH_ASSOC);
		$id_voyageur=$row70['id_voyageur'];
		if ($id_voyageur=="")		// ce n'est pas un voyageur occasionnel
			$id_voyageur="NULL";

		$id_voyageur2="SELECT id_voyageur from voyageur_regulier WHERE nom='".$nom."' AND prenom='".$prenom."' AND numero_tel='".$telephone."';";
	   	$resultset71= $connexion->prepare($id_voyageur2);
		$resultset71->execute();
		$row71 = $resultset71->fetch(PDO::FETCH_ASSOC);
		$id_voyageur2=$row71['id_voyageur'];
		if ($id_voyageur2=="") 		// ce n'est pas un voyageur régulier
			$id_voyageur2="NULL";
		

	    $idbillet="SELECT max(id_billet) from billet;";		// il faut créer un id_billet qui n'existe pas encore
 		$resultset0= $connexion->prepare($idbillet);
		$resultset0->execute();
		$row0 = $resultset0->fetch(PDO::FETCH_ASSOC);
		$id_billet=($row0['max'])+1;	
		
	    $gare_dep="SELECT id_gare from gare WHERE nom='".$gare_depart."';";
 		$resultset1= $connexion->prepare($gare_dep);
		$resultset1->execute();
		$row1 = $resultset1->fetch(PDO::FETCH_ASSOC);

		$gare_arr="SELECT id_gare from gare WHERE nom='".$gare_arrivee."';";
 		$resultset3= $connexion->prepare($gare_arr);
		$resultset3->execute();
		$row3 = $resultset3->fetch(PDO::FETCH_ASSOC);
		

		$arret_gare_dep="SELECT id_arret from arret WHERE fk_gare='".$row1['id_gare']."' AND fk_train='".$train1."';";
 		$resultset4= $connexion->prepare($arret_gare_dep);
		$resultset4->execute();
		$row4 = $resultset4->fetch(PDO::FETCH_ASSOC);

		
		$arret_gare_arr="SELECT id_arret from arret WHERE fk_gare='".$row3['id_gare']."' AND fk_train='".$train1."';";
 		$resultset7= $connexion->prepare($arret_gare_arr);
		$resultset7->execute();
		$row7 = $resultset7->fetch(PDO::FETCH_ASSOC);



		//////////////////////////// Création du billet ////////////////////////////
		$insertion_billet = "INSERT INTO billet(id_billet, fk_voyocc,fk_voyreg,mode_paiment,assurance,etat,date_depart,date_arrivee) VALUES ($billllet, $id_voyageur,$id_voyageur2,'$paiement',$assurance, 'payé','$date_depart','$date_depart')";
        $resultset8 = $connexion->prepare($insertion_billet);
		$resultset8->execute();

		//////////////////////////// Création du trajet ////////////////////////////
		$insertion48 = "INSERT INTO trajet(fk_billet,fk_arret_depart,fk_arret_arrivee,classe, date_depart, date_arrivee) VALUES ($billllet,$row4[id_arret],$row7[id_arret], $classe1, '$date_depart','$date_depart')";
		$resultset48 = $connexion->prepare($insertion48);
		$resultset48->execute();


}






	////////////// Si trajet avec correspondance, il faut créer 1 billet et 2 trajets //////////////

	else{
	   $gare_depart=$_POST['dep'];
	   $gare_milieu=$_POST['mil'];
	   $gare_arrivee=$_POST['arr'];
	   $heure_depart=$_POST['heure_dep'];
	   $date_depart=$_POST['date_dep'];
	   $heure_milieu1=$_POST['heure_mil1'];
	   $heure_milieu2=$_POST['heure_mil2'];
	   $heure_arrivee=$_POST['heure_arr'];
	   $classe1=$_POST['classe1'];
	   $classe2=$_POST['classe2'];
	   $train1=$_POST['train1'];
	   $train2=$_POST['train2'];
	   if(isset($_POST['assurance']))
	   	$assurance="TRUE";
	   else
	   	$assurance="FALSE";
	   $paiement=$_POST['paiement'];
	   $paiement=strtolower($paiement);
	
	   $nom=$_SESSION['nom'];
	   $prenom=$_SESSION['prenom'];
	   $telephone=$_SESSION['telephone'];

	   	$id_voyageur="SELECT id_voyageur from voyageur_occasionel WHERE nom='".$nom."' AND prenom='".$prenom."' AND numero_tel='".$telephone."';";
	   	$resultset70= $connexion->prepare($id_voyageur);
		$resultset70->execute();
		$row70 = $resultset70->fetch(PDO::FETCH_ASSOC);
		$id_voyageur=$row70['id_voyageur'];
		if ($id_voyageur=="") 		// ce n'est pas un voyageur occasionnel
			$id_voyageur="NULL";
		

		$id_voyageur2="SELECT id_voyageur from voyageur_regulier WHERE nom='".$nom."' AND prenom='".$prenom."' AND numero_tel='".$telephone."';";
	   	$resultset71= $connexion->prepare($id_voyageur2);
		$resultset71->execute();
		$row71 = $resultset71->fetch(PDO::FETCH_ASSOC);
		$id_voyageur2=$row71['id_voyageur'];
		if ($id_voyageur2=="")		// ce n'est pas un voyageur régulier
			$id_voyageur2="NULL";
		

	    $idbillet="SELECT max(id_billet) from billet;";		// il faut créer un id_billet qui n'existe pas encore
 		$resultset0= $connexion->prepare($idbillet);
		$resultset0->execute();
		$row0 = $resultset0->fetch(PDO::FETCH_ASSOC);
		$id_billet=($row0['max'])+1;
		
	    $gare_dep="SELECT id_gare from gare WHERE nom='".$gare_depart."';";
 		$resultset1= $connexion->prepare($gare_dep);
		$resultset1->execute();
		$row1 = $resultset1->fetch(PDO::FETCH_ASSOC);

		$gare_mil="SELECT id_gare from gare WHERE nom='".$gare_milieu."';";
 		$resultset2= $connexion->prepare($gare_mil);
		$resultset2->execute();
		$row2 = $resultset2->fetch(PDO::FETCH_ASSOC);

		$gare_arr="SELECT id_gare from gare WHERE nom='".$gare_arrivee."';";
 		$resultset3= $connexion->prepare($gare_arr);
		$resultset3->execute();
		$row3 = $resultset3->fetch(PDO::FETCH_ASSOC);
		


		$arret_gare_dep="SELECT id_arret from arret WHERE fk_gare='".$row1['id_gare']."' AND fk_train='".$train1."';";
 		$resultset4= $connexion->prepare($arret_gare_dep);
		$resultset4->execute();
		$row4 = $resultset4->fetch(PDO::FETCH_ASSOC);

		$arret_gare_milieu1="SELECT id_arret from arret WHERE fk_gare='".$row2['id_gare']."' AND fk_train='".$train1."';";
 		$resultset5= $connexion->prepare($arret_gare_milieu1);
		$resultset5->execute();
		$row5 = $resultset5->fetch(PDO::FETCH_ASSOC);

		$arret_gare_milieu2="SELECT id_arret from arret WHERE fk_gare='".$row2['id_gare']."' AND fk_train='".$train2."';";
 		$resultset6= $connexion->prepare($arret_gare_milieu2);
		$resultset6->execute();
		$row6 = $resultset6->fetch(PDO::FETCH_ASSOC);

		$arret_gare_arr="SELECT id_arret from arret WHERE fk_gare='".$row3['id_gare']."' AND fk_train='".$train2."';";
 		$resultset7= $connexion->prepare($arret_gare_arr);
		$resultset7->execute();
		$row7 = $resultset7->fetch(PDO::FETCH_ASSOC);


		//////////////////////////// Création du billet ////////////////////////////
		$insertion_billet = "INSERT INTO billet(id_billet, fk_voyocc,fk_voyreg,mode_paiment,assurance,etat,date_depart,date_arrivee) VALUES ($billllet, $id_voyageur,$id_voyageur2,'$paiement',$assurance, 'payé','$date_depart','$date_depart')";
        $resultset8 = $connexion->prepare($insertion_billet);
		$resultset8->execute();

		//////////////////////////// Création du trajet 1 ////////////////////////////
		$insertion48 = "INSERT INTO trajet(fk_billet,fk_arret_depart,fk_arret_arrivee,classe, date_depart, date_arrivee) VALUES ($billllet,$row4[id_arret],$row5[id_arret], $classe1, '$date_depart','$date_depart')";
		$resultset48 = $connexion->prepare($insertion48);
		$resultset48->execute();

		//////////////////////////// Création du trajet 2 ////////////////////////////
		$insertion46 = "INSERT INTO trajet(fk_billet,fk_arret_depart,fk_arret_arrivee,classe, date_depart, date_arrivee) VALUES ($billllet,$row6[id_arret],$row7[id_arret], $classe2, '$date_depart','$date_depart')";
		$resultset46 = $connexion->prepare($insertion46);
		$resultset46->execute();

}

	$connexion=null;
	header('Location: historique.php');
 	exit();
?>
</body>
</html>