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
$correspondance=$_POST['correspondance'];

if(!$correspondance){
   $gare_depart=$_POST['dep'];  
   $gare_arrivee=$_POST['arr'];
   $heure_depart=$_POST['heure_dep'];
   $date_depart=$_POST['date_dep'];
   $heure_arrivee=$_POST['heure_arr'];
   $classe=$_POST['classe'];
   $train1=$_POST['train1'];

   $prix_assurance=2;
   $assurance="TRUE";
   echo "<div class='annulation_texte'>Êtes-vous sûr de vouloir réserver ce billet ? </div>


   <form class='form_assurance' method='post' action='reserver.php'>


  <input type='hidden' name='correspondance' value='0'><input type='hidden' name='classe' value='".$classe."'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$heure_depart."'><input type='hidden' name='date_dep' value='".$date_depart."'><input type='hidden' name='heure_arr' value='".$heure_arrivee."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$train1."'>
            
     <input type='submit' class='annulation_bouton_supprimer' value='OUI'>
     <a href='../index.php' class='annulation_bouton_passupprimer'>NON</a>
     <div class='reservation_assurance'>Voulez-vous prendre une assurance annulation pour ".$prix_assurance."€ de plus ?</div>
     
     <input class='check_assurance' type='checkbox' name='assurance'>
     <select name='paiement'>
      <option value='Chèque'>chèque</option> 
      <option value='Carte'>carte</option>
      <option value='Espèce'>espèce</option>
    </select>";

if($classe==1)
    echo "<select name='classe1'><option value='2'>2nd classe</option> <option selected value='1'>1ere classe</option></select>";
    
else
  echo "<select name='classe1'><option selected value='2'>2nd classe</option> <option value='1'>1ere classe</option></select>";
 
   

                     echo "<div class='reserver_historique_billet'>";
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
                echo $heure_arrivee;
                echo "</div>";
                echo "<div class='historique_gare_arrivee'>";
                    echo $gare_arrivee;
                    echo "</div>";
                    echo "<img src='logo.png' class='historique_logo_train'>";
                echo "<div class='historique_train'>";
                    echo "train n°".$train1;
                    echo "</div>";
                  
              echo "</div>";

}









if($correspondance){
   $gare_depart=$_POST['dep'];
   $gare_milieu=$_POST['mil'];
   $gare_arrivee=$_POST['arr'];
   $heure_depart=$_POST['heure_dep'];
   $date_depart=$_POST['date_dep'];
   $heure_milieu1=$_POST['heure_mil1'];
   $heure_milieu2=$_POST['heure_mil2'];
   $heure_arrivee=$_POST['heure_arr'];
   $classe=$_POST['classe'];
   $train1=$_POST['train1'];
   $train2=$_POST['train2'];

   $type1="SELECT type_train.nom from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$train1.";";
   $resultset1= $connexion->prepare($type1);
   $resultset1->execute();
   $row1 = $resultset1->fetch(PDO::FETCH_ASSOC);
   $type_train1=$row1['nom'];

   $type2="SELECT type_train.nom from type_train, train WHERE train.fk_type=type_train.nom AND train.numero_train=".$train2.";";
   $resultset2= $connexion->prepare($type2);
   $resultset2->execute();
   $row2 = $resultset2->fetch(PDO::FETCH_ASSOC);
   $type_train2=$row2['nom'];


    $classe1_dispo_train1="SELECT type_train.premiere_classe from type_train WHERE type_train.nom='".$type_train1."';";
    $resultset3= $connexion->prepare($classe1_dispo_train1);
    $resultset3->execute();
    $row3 = $resultset3->fetch(PDO::FETCH_ASSOC);
    $premiere_classe_dispo_train1=$row3['premiere_classe'];

    $classe1_dispo_train2="SELECT type_train.premiere_classe from type_train WHERE type_train.nom='".$type_train2."';";
    $resultset4= $connexion->prepare($classe1_dispo_train2);
    $resultset4->execute();
    $row4 = $resultset4->fetch(PDO::FETCH_ASSOC);
    $premiere_classe_dispo_train2=$row4['premiere_classe'];



   $prix_assurance=2;
   $assurance="TRUE";
   echo "<div class='annulation_texte'>Êtes-vous sûr de vouloir réserver ce billet ? </div>


   <form class='form_assurance' method='post' action='reserver.php'>


<input type='hidden' name='correspondance' value='1'><input type='hidden' name='classe' value='".$classe."'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$gare_milieu."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$heure_depart."'><input type='hidden' name='date_dep' value='".$date_depart."'><input type='hidden' name='heure_mil1' value='".$heure_milieu1."'><input type='hidden' name='heure_mil2' value='".$heure_milieu2."'><input type='hidden' name='heure_arr' value='".$heure_arrivee."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$train1."'><input type='hidden' name='train2' value='".$train2."'>

<input type='hidden' name='correspondance' value='1'><input type='hidden' name='classe' value='".$classe."'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$gare_milieu."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$heure_depart."'><input type='hidden' name='date_dep' value='".$date_depart."'><input type='hidden' name='heure_mil1' value='".$heure_milieu1."'><input type='hidden' name='heure_mil2' value='".$heure_milieu2."'><input type='hidden' name='heure_arr' value='".$heure_arrivee."'><input type='hidden' name='classe' value='1'><input type='hidden' name='train1' value='".$train1."'><input type='hidden' name='train2' value='".$train2."'>
           

<input type='submit' class='annulation_bouton_supprimer' value='OUI'>
     <a href='../index.php' class='annulation_bouton_passupprimer'>NON</a>
     <div class='reservation_assurance'>Voulez-vous prendre une assurance annulation pour ".$prix_assurance."€ de plus ?</div>
     
     <input class='check_assurance' type='checkbox' name='assurance'>
     <select name='paiement'>
      <option value='Chèque'>chèque</option> 
      <option value='Carte'>carte</option>
      <option value='Espèce'>espèce</option>
    </select>";

if($classe==1){
  
    echo "<select name='classe1'>";
    echo "<option value='2'>2nd classe</option>";
    if($premiere_classe_dispo_train1)
      echo "<option selected value='1'>1ere classe</option>";
    echo "</select>";
  
    echo "<select name='classe2'>";
    echo "<option value='2'>2nd classe</option>";
    if($premiere_classe_dispo_train2)
      echo "<option selected value='1'>1ere classe</option>";
    echo "</select>";
}
else{
  
    echo "<select name='classe1'>";
    echo "<option selected value='2'>2nd classe</option>";
    if($premiere_classe_dispo_train1)
      echo "<option value='1'>1ere classe</option>";
    echo "</select>";
  
    echo "<select name='classe2'>";
    echo "<option selected value='2'>2nd classe</option>";
    if($premiere_classe_dispo_train2)
      echo "<option value='1'>1ere classe</option>";
    echo "</select>";

}
   

                     echo "<div class='reserver_historique_billet'>";
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
                           echo "<img src='logo.png' class='historique_logo_train'>";
                           echo "<div class='historique_train'>";
                        echo $type_train1." n°".$train1;
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
                           echo "<img src='logo.png' class='historique_logo_train'>";
                           echo "<div class='historique_train'>";
                        echo $type_train2." n°".$train2;
                           echo "</div>";
                     echo "</div>";
                  
                  echo "</div>";

}


echo "<div class='titre_logement'>Logement</div>";
echo "<div class='titre_transport'>Transport</div>";


  $lieu_interet="SELECT * from lieu_interet WHERE lieu_interet.fk_gare = (SELECT gare.id_gare FROM gare where gare.nom='".$gare_arrivee."')";
  $resultset= $connexion->prepare($lieu_interet);
  $resultset->execute();
  while ($row = $resultset->fetch(PDO::FETCH_ASSOC)){
    if($row['type_lieu']=='Logement'){
      echo "<div class='box_logement'>";
      echo $row['nom_lt']."<br>adresse: ".$row['adresse_lt']."<br>";
      if($row['telephone_lt']!="") 
        echo "tel: ".$row['telephone_lt'];
      echo "</div>"; 
    }
    if($row['type_lieu']=='Transport'){
      echo "<div class='box_transport'>";
      echo $row['nom_lt'];
      echo "<br>tel: ".$row['telephone_lt'];
      echo "</div>";
    }
  }

  


$connexion=null;
?>
</body>
</html>