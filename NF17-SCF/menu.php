<?php
	echo "<div class='menu'>
		    <img class='logo' src='logo.png'>";

		    if(((!empty($_SESSION['nom'])))&&((!empty($_SESSION['prenom'])))&&((!empty($_SESSION['telephone']))))   // si utilisateur connecté
		    {	
				$initiale=$_SESSION['prenom'][0];
				$nom=$_SESSION['nom'];
				$prenom=$_SESSION['prenom'];
				$tel=$_SESSION['telephone'];
				echo "<div onclick='affichage_compte()' class='compte'>".$initiale."</div>";
				echo "<div style='display:none;' class='detail_compte' id='detail_compte'><div class='detail_identite'></div><b>".$prenom." ".$nom."</b><br>".$tel."<br><br><a href='client/historique.php'>Historique</a><br><br><a href='login/deconnexion.php'>Déconnexion</a></div>";
			
			    if (($_SESSION['nom']=="admin")&&($_SESSION['prenom']=="admin")&&($_SESSION['telephone']=="0000000000"))
				  echo "<a href='admin/admin.html' class='bouton_connexion'>Admin</a>";

		    }
		    else
			   echo "<a href='login/connexion.php' class='bouton_connexion'>Se connecter</a>";
	echo "</div>";
?>