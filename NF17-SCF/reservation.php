<!DOCTYPE html>
<html>
<head>
   <title>Société de chemins de fer - Horaires, Trains, Infos</title>
   <link rel="stylesheet" href="client/style_client.css" />
    <meta charset="utf-8" />
</head>
<body>

<?php 
	session_start();

   function format_date_jour_billet($date){
      $datejr = $date;
      $annee = substr($datejr, 0, 4);
      $mois = substr($datejr, 5, 2);
      $jour = substr($datejr, 8, 2);
      date_default_timezone_set('Europe/Paris');
      $jour_semaine=date("l", mktime(0, 0, 0, $mois, $jour, $annee));
      switch ($jour_semaine) {
         case "Monday":  $jour_semaine="LUNDI";  break;
         case "Tuesday":  $jour_semaine="MARDI";  break;
         case "Wednesday":  $jour_semaine="MERCREDI";  break;
         case "Thursday":  $jour_semaine="JEUDI";  break;
         case "Friday":  $jour_semaine="VENDREDI";  break;
         case "Saturday":  $jour_semaine="SAMEDI";  break;
         case "Sunday":  $jour_semaine="DIMANCHE";  break;
      }
      return $jour_semaine;
   }

   function format_date_billet($date){
      $datejr = $date;
      $mois = substr($datejr, 5, 2);
      $mois=intval($mois);
      $jour = substr($datejr, 8, 2);
      switch ($mois) {
         case 1:  $mois="janv.";  break;
         case 2:  $mois="févr.";  break;
         case 3:  $mois="mars";  break;
         case 4:  $mois="avr.";  break;
         case 5:  $mois="mai";  break;
         case 6:  $mois="juin";  break;
         case 7:  $mois="juill.";  break;
         case 8:  $mois="août";  break;
         case 9:  $mois="sept.";  break;
         case 10:  $mois="oct.";  break;
         case 11:  $mois="nov.";  break;
         case 12:  $mois="déc.";  break;
}
      $date = $jour.' '.$mois;
     return $date;
   }
   function format_date($date){
      $datejr = $date;
      $annnee = substr($datejr, 2, 2);
      $mois = substr($datejr, 5, 2);
      $jour = substr($datejr, 8, 2);
      $ndate = $jour.'/'.$mois.'/'.$annnee;
     return $ndate;
   }
   function format_heure($heure){
      $heurei = $heure;
      $heureh = substr($heurei, 0, 2);
      $heurem = substr($heurei, 3, 2);
      $heuref = $heureh.'h'.$heurem;
     return $heuref;
   }
$connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	
$correspondance=$_GET['correspondance'];
if($correspondance){
   $gare_depart=$_GET['dep'];
   $gare_milieu=$_GET['mil'];
   $gare_arrivee=$_GET['arr'];
   $heure_depart=$_GET['heure_dep'];
   $date_depart=$_GET['date_dep'];
   $heure_milieu1=$_GET['heure_mil1'];
   $heure_milieu2=$_GET['heure_mil2'];
   $heure_arrivee=$_GET['heure_arr'];
   $classe=$_GET['classe'];
   $train1=$_GET['train1'];
   $train2=$_GET['train2'];

   $assurance=2;

   include 'menu.php';

   echo "<div class='annulation_texte'>Êtes-vous sûr de vouloir réserver ce billet ? </div><a href='reserver.php?correspondance=1&dep=".$gare_depart."&train1=".$train1."&train2=".$train2."&mil=".$gare_milieu."&arr=".$gare_arrivee."&heure_dep=".$heure_depart."&heure_mil1=".$heure_milieu1."&heure_mil2=".$heure_milieu2."&heure_arr=".$heure_arrivee."&classe=2&date_dep=".$date_depart."' class='annulation_bouton_supprimer'>OUI</a><a href='index.php' class='annulation_bouton_passupprimer'>NON</a>";
  
   echo "<div class='reservation_assurance'>Voulez-vous prendre une assurance annulation pour ".$assurance."€ de plus ?</div>";
   echo "<form class='form_assurance'>
   <input class='radio_assurance' type='radio' name='assurance' value='oui'>oui
   <input class='radio_pasassurance' type='radio' name='assurance' value='non'>non
   </form>";



                     echo "<div class='historique_billet'>";
                     date_default_timezone_set('Europe/Paris');
                     $temps_billet=gmdate('H:i',strtotime($heure_arrivee)-strtotime($heure_depart));
                     echo "<div class='historique_date_jour_billet'>";
                        echo format_date_jour_billet("1998/01/01");
                        echo "</div>";
                     echo "<div class='historique_date_billet'>";
                        echo format_date_billet("1998/01/01");
                        echo "</div>";
                      echo "<div class='historique_heure_depart_billet'>";
                      echo format_heure($heure_depart);
                      echo "</div>";
                      echo "<div class='historique_depart_billet'>";
                      echo $gare_depart;
                      echo "</div>";
                      echo "<div class='chercher_temps_billet'>".$temps_billet."</div>";

                      echo "<div class='historique_heure_arrivee_billet'>".format_heure($heure_arrivee)."</div>";
                        echo "<div class='historique_arrivee_billet'>".$gare_arrivee."</div>";


                     echo "<div class='chercher_historique_trajet'>";
                        echo "<div class='historique_heure_depart'>";
                        echo $heure_depart;
                        echo "</div>";
                        echo "<div class='historique_gare_depart'>";
                        echo $gare_depart;
                        echo "</div>";

                        echo "<div class='historique_heure_arrivee'>";
                        echo $heure_milieu1;
                        echo "</div>";
                        echo "<div class='historique_gare_arrivee'>";
                           echo $gare_milieu;
                           echo "</div>";
                           echo "<img src='logo_sncf.png' class='historique_logo_train'>";
                           echo "<div class='historique_train'>";
                        echo "train n°".$train1;
                           echo "</div>";
                     echo "</div>";
                     

                     echo "<div class='chercher_historique_trajet'>";
                        echo "<div class='historique_heure_depart'>";
                        echo $heure_milieu2;
                        echo "</div>";
                        echo "<div class='historique_gare_depart'>";
                        echo $gare_milieu;
                        echo "</div>";
                        
                        echo "<div class='historique_heure_arrivee'>";
                        echo $heure_arrivee;
                        echo "</div>";
                        echo "<div class='historique_gare_arrivee'>";
                           echo $gare_arrivee;
                           echo "</div>";
                           echo "<img src='logo_sncf.png' class='historique_logo_train'>";
                           echo "<div class='historique_train'>";
                        echo "train n°".$train2;
                           echo "</div>";
                     echo "</div>";
                  
                  echo "</div>";




}

//echo "<div class='annulation_texte'>Êtes-vous sûr de vouloir réserver ce billet ? </div><a href='reserver.php?id_billet=".$id_billet."' class='annulation_bouton_supprimer'>OUI</a><a href='historique.php' class='annulation_bouton_passupprimer'>NON</a>";
   

$connexion=null;
?>
</body>
</html>