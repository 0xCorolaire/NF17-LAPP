<html>
<head>
	<title>Inscription</title>
	<meta charset="utf-8" />
	<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
	<script type="text/javascript" src="script.js"></script>
</head>
<body class="login_body">
	<img class="inscription_background" src="login_background.png">
	<div class="inscription_cercle" src="login_cercle"></div>
	<?="<form action='inscrire.php' method='post'>
			<div class='inscription_titre_inscription'>Inscription</div>
			<input type='text' name='nom' class='inscription_champ_nom' maxlength='20' placeholder='Nom' required autofocus>
			<input type='text' name='prenom' class='inscription_champ_prenom' maxlength='20' placeholder='Prénom' required>
			<input type='text' name='telephone' class='inscription_champ_num' maxlength='10' placeholder='Téléphone' onKeypress='if(event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;if(event.which < 48 || event.which > 57) return false;' onkeyup='expression=new RegExp('^([0-9]{2}-){0-3}[0-9]{2}$',''); if (expression.test(this.value)) { this.value = '-'; }' required>
			<textarea class='inscription_champ_adresse' name='adresse' placeholder='Adresse' required></textarea>
			<input class='inscription_champ_valider' type='submit' value='OK' >
			<div class='inscription_info_erreurs'></div>
			<a href='connexion.php' class='inscription_titre_connexion'>Connexion</a>
		</form>";?>
</body>
</html>