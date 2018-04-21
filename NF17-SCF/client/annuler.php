<?php
	session_start();

	$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	
	$id_billet=$_GET['id_billet'];
	$annulation="UPDATE billet
				 SET etat='annulé'
				 FROM voyageur_occasionel, voyageur_regulier
				 WHERE (billet.id_billet='".$id_billet."'
				 		AND (voyageur_occasionel.nom='".$_SESSION['nom']."' AND voyageur_occasionel.prenom='".$_SESSION['prenom']."' AND voyageur_occasionel.numero_tel='".$_SESSION['telephone']."' AND billet.fk_voyocc=voyageur_occasionel.id_voyageur)
				 			OR
				 			(voyageur_regulier.nom='".$_SESSION['nom']."' AND voyageur_regulier.prenom='".$_SESSION['prenom']."' AND voyageur_regulier.numero_tel='".$_SESSION['telephone']."' AND fk_voyreg=voyageur_regulier.id_voyageur))";
	
	$resultset = $connexion->prepare($annulation);
	$resultset->execute();

	$connexion=null;

	header('Location: historique.php');
 	exit();
?>