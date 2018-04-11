<html>
<head>
	<title>Connexion</title>
	<meta charset="utf-8" />
	<link href="style.css" rel="stylesheet" media="all" type="text/css"> 
	<script type="text/javascript" src="script.js"></script>
</head>
<body class="login_body">
	<img class="login_background" src="login_background.png">
	<div class="login_cercle" src="login_cercle"></div>
	<?="<form action='connecter.php' method='post'>
			<div class='login_titre_login'>Connexion</div>
			<input type='text' name='nom' class='login_champ_nom' maxlength='20' placeholder='Nom' required autofocus>
			<input type='text' name='prenom' class='login_champ_prenom' maxlength='20' placeholder='Prénom' required>
			<input type='text' name='telephone' class='login_champ_num' maxlength='10' placeholder='Téléphone' onKeypress='if(event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;if(event.which < 48 || event.which > 57) return false;' onkeyup='expression=new RegExp('^([0-9]{2}-){0-3}[0-9]{2}$',''); if (expression.test(this.value)) { this.value = '-'; }' required>
			<input class='login_champ_valider' type='submit' value='OK' >
			<div class='login_info_erreurs'></div>
			<a href='inscription.php' class='login_titre_inscription'>Inscription</a>
		</form>";?>
</body>
</html>