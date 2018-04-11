<!DOCTYPE html>
<html>
<head>
   <title>Société de chemins de fer - Horaires, Trains, Infos</title>
   <link rel="stylesheet" href="style_client.css" />
   <link rel="stylesheet" href="../style.css" />
   <meta charset="utf-8" />
   <script type="text/javascript">
   function affichage_compte(){
      if (document.getElementById('detail_compte').style.display=="none")
         document.getElementById('detail_compte').style.display="block";
      else
         document.getElementById('detail_compte').style.display="none";
   }
   </script>
</head>
<body>

<?php 
	session_start();

   include 'menu.php';

   include 'format_donnees.php';

   
$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	

$billet="SELECT billet.id_billet AS billet, billet.assurance, billet.etat, MIN(trajet.date_depart) FROM billet, trajet, voyageur_regulier, voyageur_occasionel WHERE trajet.fk_billet=billet.id_billet AND billet.fk_voyocc='2' AND billet.fk_voyocc=voyageur_occasionel.id_voyageur AND (voyageur_occasionel.nom='".$_SESSION['nom']."' AND voyageur_occasionel.prenom='".$_SESSION['prenom']."' AND voyageur_occasionel.numero_tel='".$_SESSION['telephone']."') OR (voyageur_regulier.nom='".$_SESSION['nom']."' AND voyageur_regulier.prenom='".$_SESSION['prenom']."' AND voyageur_regulier.numero_tel='".$_SESSION['telephone']."') GROUP BY billet.id_billet ORDER BY min DESC;";

$resultset1 = $connexion->prepare($billet);
$resultset1->execute();
$billet=1;
while ($row1 = $resultset1->fetch(PDO::FETCH_ASSOC)) {   // pour tout les billets du client
   echo "<div class='historique_billet'>";
   $depart="SELECT type_train.nom AS type, train.numero_train, gare.nom, trajet.date_depart, trajet.place, trajet.classe, arret.heure_depart 
FROM trajet
   JOIN arret
      ON trajet.fk_arret_depart=arret.id_arret
      JOIN gare
         ON arret.fk_gare=gare.id_gare
         JOIN train
            ON arret.fk_train=train.numero_train
            JOIN type_train
               ON train.fk_type=type_train.nom
WHERE trajet.fk_billet='$row1[billet]'
ORDER BY trajet.date_depart ASC;";
 
$arrivee="SELECT gare.nom, trajet.date_arrivee, arret.heure_arrivee
FROM trajet
   JOIN arret
      ON  trajet.fk_arret_arrivee=arret.id_arret
      JOIN gare
         ON arret.fk_gare=gare.id_gare
         JOIN train
            ON arret.fk_train=train.numero_train
            JOIN type_train
               ON train.fk_type=type_train.nom
WHERE trajet.fk_billet='$row1[billet]'
ORDER BY trajet.date_depart ASC;";

$resultset2 = $connexion->prepare($depart);
$resultset2->execute();
$resultset3 = $connexion->prepare($arrivee);
$resultset3->execute();
$trajet=1;
while ($row2 = $resultset2->fetch(PDO::FETCH_ASSOC)) {      // Afficher chaque trajet
   $row3 = $resultset3->fetch(PDO::FETCH_ASSOC);
   if ($trajet==1){
      echo "<div class='historique_date_jour_billet'>";
         echo format_date_jour_billet($row2['date_depart']);
      echo "</div>";
      echo "<div class='historique_date_billet'>";
         echo format_date_billet($row2['date_depart']);
      echo "</div>";
      echo "<div class='historique_heure_depart_billet'>";
         echo format_heure($row2['heure_depart']);
      echo "</div>";
      echo "<div class='historique_depart_billet'>";
         echo $row2['nom'];
      echo "</div>";
      if(($row2['date_depart']>date("Y-m-d"))&&($row1['etat']!="annulé")){
         if($row1['assurance'])
            echo "<a href='annulation.php?id_billet=".$row1['billet']."' class='historique_modifier_billet'>Modifier</a>";
         else
            echo "<a href='annulation.php?id_billet=".$row1['billet']."' class='historique_modifier_billet' style='visibility:hidden;'>Modifier</a>";
         echo "<a href='annulation.php?id_billet=".$row1['billet']."' class='historique_annuler_billet'>Annuler</a>";
      }
      else
         echo "<a href='annulation.php?id_billet=".$row1['billet']."' class='historique_modifier_billet' style='visibility:hidden;'>Modifier</a>";
         echo "<a href='annulation.php?id_billet=".$row1['billet']."' class='historique_annuler_billet' style='visibility:hidden;'>Annuler</a>";
      
      echo "<div id='historique_heure_arrivee_billet".$billet."' class='historique_heure_arrivee_billet'></div>";
      echo "<div id='historique_arrivee_billet".$billet."' class='historique_arrivee_billet'></div>";

      
      
      
   }
   echo "<div class='historique_trajet'>";
      echo "<div class='historique_heure_depart'>";
         echo format_date($row2['date_depart'])." à ".format_heure($row2['heure_depart']);
      echo "</div>";
      echo "<div class='historique_gare_depart'>";
         echo $row2['nom'];
      echo "</div>";

      echo "<div class='historique_heure_arrivee'>";
         echo format_date($row3['date_arrivee'])." à ".format_heure($row3['heure_arrivee']);
      echo "</div>";
      echo "<div class='historique_gare_arrivee'>";
         echo $row3['nom'];
      echo "</div>";
     
      echo "<img src='logo.png' class='historique_logo_train'>";

      echo "<div class='historique_train'>";
         echo $row2['type']." n°".$row2['numero_train'];
      echo "</div>";
      
      echo "<div class='historique_client'>";
         echo $_SESSION['prenom']." ".$_SESSION['nom'];
      echo "</div>";

      echo "<div class='historique_classe'>";
         echo "Classe ".$row2['classe']."<br>place n°".$row2['place'];
      echo "</div>";
   echo "</div>";
   
   $trajet++;
}
?>
<script type="text/javascript">
document.getElementById("historique_arrivee_billet<?php echo $billet;?>").innerHTML = "<?php echo $row3['nom'];?>";
document.getElementById("historique_heure_arrivee_billet<?php echo $billet;?>").innerHTML = "<?php echo format_heure($row3['heure_arrivee']);?>";
</script>
  <?php   
  if($row1['etat']=='annulé')
   echo "<div class='historique_bandeau_annule'>ANNULÉ</div>";
echo "</div>";
$billet++;

}

$connexion=null;
?>
</body>
</html>