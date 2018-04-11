<?php
	session_start();
	$error="";
	$voyageur_connecte=0;

	// Vérifications champs textes pas vides
	if((!empty($_POST['nom']))&&(!empty($_POST['prenom']))&&(!empty($_POST['telephone'])))
	{
		//recherche d'un voyageur avec les identifiants saisis
		$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	
		$sql = "SELECT voyageur_occasionel.id_voyageur
		FROM voyageur_occasionel
		WHERE voyageur_occasionel.prenom='".$_POST['prenom']."' AND voyageur_occasionel.numero_tel='".$_POST['telephone']."' AND voyageur_occasionel.nom='".$_POST['nom']."';";
		$resultset = $connexion->prepare($sql);
		$resultset->execute();
		while ($row = $resultset->fetch(PDO::FETCH_ASSOC))
			$voyageur_connecte++;

		$sql = "SELECT voyageur_regulier.id_voyageur
		FROM voyageur_regulier
		WHERE voyageur_regulier.prenom='".$_POST['prenom']."' AND voyageur_regulier.numero_tel='".$_POST['telephone']."' AND voyageur_regulier.nom='".$_POST['nom']."';";
		$resultset = $connexion->prepare($sql);
		$resultset->execute();
		while ($row = $resultset->fetch(PDO::FETCH_ASSOC))
			$voyageur_connecte++;

		$connexion=null;

		/*	verification que le couple (nom, prenom, telephone) existe dans la BDD
			si ce couple existe, le client s'est connecte avec des identifiants correct, il est redirige vers la page d'accueil
		*/
		if($voyageur_connecte==1)
		{
			$_SESSION['nom'] = $_POST['nom'];
			$_SESSION['prenom'] = $_POST['prenom'];
			$_SESSION['telephone'] = $_POST['telephone'];
			header('Location: ../index.php');
		}
		else
		{
			$error="Nous n'avons pas trouvé votre compte.";
		}
	}
	else	
	{	
		$error="Veuillez remplir tous les champs.";
	}	
		
	//renvoyer le formulaire si il y a des erreurs
	if (!empty($error))
	{
		echo "<html>
<head>
	<title>Connexion</title>
	<meta charset='utf-8' />
	<link href='style.css' rel='stylesheet' media='all' type='text/css'> 
	<script type='text/javascript' src='script.js'></script>
</head>
<body class='login_body'>
	<img class='login_background' src='login_background.png'>
	<div class='login_cercle' src='login_cercle'></div>
	<form action='connecter.php' method='post'>
			<div class='login_titre_login'>Connexion</div>
			<input type='text' name='nom' class='login_champ_nom' maxlength='20' placeholder='Nom' value='".$_POST['nom']."' required autofocus>
			<input type='text' name='prenom' class='login_champ_prenom' maxlength='20' placeholder='Prénom' value='".$_POST['prenom']."' required>
			<input type='text' name='telephone' class='login_champ_num' maxlength='10' placeholder='Téléphone' onKeypress='if(event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;if(event.which < 48 || event.which > 57) return false;' onkeyup='expression=new RegExp('^([0-9]{2}-){0-3}[0-9]{2}$',''); if (expression.test(this.value)) { this.value = '-'; }'  value='".$_POST['telephone']."' required>
			<input class='login_champ_valider' type='submit' value='OK' >
			<div class='login_info_erreurs'>".$error."</div>
			<a href='inscription.php' class='login_titre_inscription'>Inscription</a>
		</form>
</body>
</html>";
	}
?>