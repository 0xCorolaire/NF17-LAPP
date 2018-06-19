<?php
	session_start();
	$error="";
	// Vérifications champs textes pas vides
	if((!empty($_POST['nom']))&&(!empty($_POST['prenom']))&&(!empty($_POST['telephone']))&&(!empty($_POST['adresse'])))
	{
		
		$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));	
		$nom=$_POST['nom'];$prenom=$_POST['prenom'];$telephone=$_POST['telephone'];$adresse=$_POST['adresse'];
		
		/** Ajout du client dans la table voyageur_occasionel **/
		$sql = "INSERT INTO voyageur_occasionel(nom,prenom,numero_tel,adresse) VALUES ('$nom','$prenom','$telephone','adresse')";
        $result = $connexion->prepare($sql);
        $result->execute();

		if ($result){
			echo "Votre compte a bien été créé. Vous allez être redirigé.";
		 	header("Refresh: 2;url=../../index.php");
		}
		else {
		  echo "Une erreur s'est produite.";
		}

		$connexion=null;

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
	<title>Inscription</title>
	<meta charset='utf-8'/>
	<link href='style.css' rel='stylesheet' media='all' type='text/css'> 
	<script type='text/javascript' src='script.js'></script>
</head>
<body class='login_body'>
	<img class='inscription_background' src='login_background.png'>
	<div class='inscription_cercle' src='login_cercle'></div>
		<form action='inscrire.php' method='post'>
			<div class='inscription_titre_inscription'>Inscription</div>
			<input type='text' name='nom' class='inscription_champ_nom' maxlength='20' placeholder='Nom' value='".$_POST['nom']."' required autofocus>
			<input type='text' name='prenom' class='inscription_champ_prenom' maxlength='20' placeholder='Prénom' value='".$_POST['prenom']."' required>
			<input type='text' name='telephone' class='inscription_champ_num' maxlength='10' placeholder='Téléphone' onKeypress='if(event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;if(event.which < 48 || event.which > 57) return false;' onkeyup='expression=new RegExp('^([0-9]{2}-){0-3}[0-9]{2}$',''); if (expression.test(this.value)) { this.value = '-'; }' value='".$_POST['telephone']."' required>
			<textarea class='inscription_champ_adresse' name='adresse' placeholder='Adresse' required>".$_POST['adresse']."</textarea>
			<input class='inscription_champ_valider' type='submit' value='OK' >
			<div class='inscription_info_erreurs'>".$error."</div>
			<a href='connexion.php' class='inscription_titre_connexion'>Connexion</a>
		</form>
</body>
</html>";
	}
?>