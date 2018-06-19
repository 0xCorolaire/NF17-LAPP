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



 function calculer_prix_billet(){
        var correspondance=<?=$_POST['correspondance']?>;
        if(correspondance==0){
        var prix_billet, prix1train1, prix2train1;
        var select = document.getElementById("assurance").checked;
        
          var select1 = document.getElementById("classetrain1").value;
          prix1train1=<?=$_POST['prix1train1']?>;
          prix2train1=<?=$_POST['prix2train1']?>;
          if(select1==1)
            prix_billet=prix1train1
          if(select1==2)
            prix_billet=prix2train1;
        prix_total=prix_billet;
        if(select){
          prix_total+=2;
          document.getElementById("prix_assurance").innerHTML="2€";
        }
        else{
          document.getElementById("prix_assurance").innerHTML="0€";
        }
        document.getElementById("prix_total_billet").innerHTML=prix_billet+"€";
        document.getElementById("prix_total_total").innerHTML=prix_total+"€";
         
        }
        else{
          var cprix_total, cprix_billet, cprix1train1, cprix1train2, cprix2train1, cprix2train2;
          var select = document.getElementById("correspondance_assurance").checked;
          var select1 = document.getElementById("correspondance_classetrain1").value;
          var select2 = document.getElementById("correspondance_classetrain2").value;
          cprix1train1=<?=$_POST['prix1train1']?>;
          cprix1train2=<?php if($_POST['correspondance']){echo $_POST['prix1train2'];}else echo "0";?>;
          cprix2train1=<?=$_POST['prix2train1']?>;
          cprix2train2=<?php if($_POST['correspondance']){echo $_POST['prix2train2'];}else echo "0";?>;
          if(select1==1 && select2==1)
            cprix_billet=cprix1train1+cprix1train2;
          if(select1==1 && select2==2)
            cprix_billet=cprix1train1+cprix2train2;
          if(select1==2 && select2==1)
            cprix_billet=cprix2train1+cprix1train2;
          if(select1==2 && select2==2)
            cprix_billet=cprix2train1+cprix2train2;
          cprix_total=cprix_billet;
          if(select){
          cprix_total+=2;
          document.getElementById("correspondance_prix_assurance").innerHTML="2€";
        }
        else{
          document.getElementById("correspondance_prix_assurance").innerHTML="0€";
        }
          document.getElementById("correspondance_prix_total_billet").innerHTML=cprix_billet+"€";
          document.getElementById("correspondance_prix_total_total").innerHTML=cprix_total+"€";
        }
        }
      

     
    </script>
  </head>
  <body onload='calculer_prix_billet();'>
  <?php 
	  session_start();
    include 'menu.php';
 $lol=$_POST['prix1train1'];
    if(empty($_SESSION['nom']) || empty($_SESSION['prenom']) || empty($_SESSION['telephone']))   // Utilisateur pas connecté
      echo "Vous devez être connecté pour réserver des billets.";
    else{     // Utilisateur connecté
      echo "<div class='reservation_recapitulatif'>";
      echo "<div class='reservation_partie_billet'>";
      include 'format_donnees.php';

      $connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbnf17p050', 'nf17p050', 'klfRl2NH');	

$traj=$_POST["traj"];
      $suppression_trajet = "DELETE FROM trajet WHERE id_trajet='$traj';";
      $resultset8 = $connexion->prepare($suppression_trajet);
      $resultset8->execute();


      $correspondance=$_POST['correspondance'];
      if(!$correspondance){     // billet avec 1 trajet (train direct)
        $gare_depart=$_POST['dep'];  
        $gare_arrivee=$_POST['arr'];
        $heure_depart=$_POST['heure_dep'];
        $date_depart=$_POST['date_dep'];
        $heure_arrivee=$_POST['heure_arr'];
        $classe=$_POST['classe'];
        $train1=$_POST['train1'];
        $prix_assurance=2;
        $assurance="TRUE";
   
        echo "<form class='form_assurance' method='post' action='reserver2.php'>
        <input type='hidden' name='billet' value='".$_POST['bill']."'>
            <input type='hidden' name='correspondance' value='0'><input type='hidden' name='classe' value='".$classe."'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$heure_depart."'><input type='hidden' name='date_dep' value='".$date_depart."'><input type='hidden' name='heure_arr' value='".$heure_arrivee."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$train1."'>";   
            
        echo "<div class='reservation_historique_billet'>";      // Info billet
        date_default_timezone_set('Europe/Paris');
        $temps_billet=gmdate('H:i',strtotime($heure_arrivee)-strtotime($heure_depart));
        echo "<div class='historique_date_jour_billet'>";
        echo format_date_jour_billet($date_depart);
        echo "</div>";
        echo "<div class='historique_date_billet'>";
        echo format_date_billet($date_depart);
        echo "</div>";
        echo "<div class='reservation_heure_depart_billet'>";
        echo format_heure($heure_depart);
        echo "</div>";
        echo "<div class='reservation_depart_billet'>";
        echo $gare_depart;
        echo "</div>";
        echo "<div class='reservation_temps_billet'>".$temps_billet."</div>";
        echo "<div class='reservation_heure_arrivee_billet'>".format_heure($heure_arrivee)."</div>";
        echo "<div class='reservation_arrivee_billet'>".$gare_arrivee."</div>";   // Fin  Info billet
      
        echo "<div class='chercher_historique_trajet'>";  // Info Trajet
        echo "<div class='historique_heure_depart'>";
        echo $heure_depart;
        echo "</div>";
        echo "<div class='reservation_gare_depart'>";
        echo $gare_depart;
        echo "</div>";
        echo "<div class='historique_heure_arrivee'>";
        echo $heure_arrivee;
        echo "</div>";
        echo "<div class='reservation_gare_arrivee'>";
        echo $gare_arrivee;
        echo "</div>";
        echo "<img src='logo.png' class='reservation_logo_train'>";
        echo "<div class='reservation_train'>";
        echo "train n°".$train1;
        echo "</div>";
        echo "<div class='reservation_place'>";
        echo "place n° 132";
        echo "</div>";      // Fin Info Trajet

                  
        if($classe==1)
          echo "<select onchange='calculer_prix_billet()' id='classetrain1' class='reservation_select_classe_train' name='classe1'><option value='2'>2nd classe</option> <option selected value='1'>1ere classe</option></select>";
        else
          echo "<select onchange='calculer_prix_billet()' id='classetrain1' class='reservation_select_classe_train' name='classe1'><option selected value='2'>2nd classe</option> <option value='1'>1ere classe</option></select>";
 
        echo "</div>";
        echo "</div>";


// checkbox assurance
echo "<div class='reservation_box_assurance'>   
      <div class='reservation_assurance'>Assurance annulation pour ".$prix_assurance."€ de plus</div>
      <label class='container'>
      <input onchange='calculer_prix_billet()' type='checkbox' id='assurance' name='assurance'>
      <span class='checkmark'></span>
      </label>
      </div>";





 echo "<div id='lieu_interet'>
      <div class='column'>";
    
      $lieu_interet="SELECT * from lieu_interet WHERE lieu_interet.fk_gare = (SELECT gare.id_gare FROM gare where gare.nom='".$gare_arrivee."')";
      $resultset= $connexion->prepare($lieu_interet);
      $resultset->execute();
      while ($row = $resultset->fetch(PDO::FETCH_ASSOC)){
        if($row['type_lieu']=='Logement'){
          echo "<div class='box'>";
          echo $row['nom_lt']."<br>adresse: ".$row['adresse_lt']."<br>";
          if($row['telephone_lt']!="") 
            echo "tel: ".$row['telephone_lt'];
          echo "</div>"; 
        }
      }
      echo "</div>


      <div class='column'>";
      $lieu_interet="SELECT * from lieu_interet WHERE lieu_interet.fk_gare = (SELECT gare.id_gare FROM gare where gare.nom='".$gare_arrivee."')";
      $resultset= $connexion->prepare($lieu_interet);
      $resultset->execute();
      while ($row = $resultset->fetch(PDO::FETCH_ASSOC)){
        if($row['type_lieu']=='Transport'){
          echo "<div class='box'>";
          echo $row['nom_lt']."<br>adresse: ".$row['adresse_lt']."<br>";
          if($row['telephone_lt']!="") 
            echo "tel: ".$row['telephone_lt'];
          echo "</div>"; 
        }
      }
      echo"</div></div>";






        echo "</div>";


        echo "<div class='reservation_partie_paiement'>";
        echo "<div class='reservation_box_paiement'>";   





         echo "<div class='reservation_total'>Récapitulatif</div>";
        echo "<div class='reservation_total_billet'>Billet</div>";
        echo "<div id='prix_total_billet' class='reservation_total_prix_billet'></div>";
        echo "<div class='reservation_total_assurance'>Assurance</div>";
        echo "<div id='prix_assurance' class='reservation_total_prix_assurance'></div>";
        

     echo "<select class='reservation_paiement' name='paiement'>
        <option value='Chèque'>chèque</option> 
        <option value='Carte'>carte</option>
        <option value='Espèce'>espèce</option>
        </select><br><br>";

  echo "<div class='reservation_box_total'>
        <div class='reservation_box_titre_total'>Total</div>
        <div id='prix_total_total' class='reservation_box_prix_total'></div>
        </div>";


       echo "
        <input type='submit' class='reservation_bouton_valider' value='VALIDER'>
            <a href='../index.php' class='reservation_bouton_annuler'>ANNULER</a>
          ";
        echo "</div>";
        echo "</div>";
      }
      else{   // billet avec 2 trajets (correspondance)
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
   
        echo "<form class='form_assurance' method='post' action='reserver2.php'>
        <input type='hidden' name='billet' value='".$_POST['bill']."'>
        <input type='hidden' name='correspondance' value='1'><input type='hidden' name='classe' value='".$classe."'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$gare_milieu."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$heure_depart."'><input type='hidden' name='date_dep' value='".$date_depart."'><input type='hidden' name='heure_mil1' value='".$heure_milieu1."'><input type='hidden' name='heure_mil2' value='".$heure_milieu2."'><input type='hidden' name='heure_arr' value='".$heure_arrivee."'><input type='hidden' name='classe' value='2'><input type='hidden' name='train1' value='".$train1."'><input type='hidden' name='train2' value='".$train2."'>
        <input type='hidden' name='correspondance' value='1'><input type='hidden' name='classe' value='".$classe."'><input type='hidden' name='dep' value='".$gare_depart."'><input type='hidden' name='mil' value='".$gare_milieu."'><input type='hidden' name='arr' value='".$gare_arrivee."'><input type='hidden' name='heure_dep' value='".$heure_depart."'><input type='hidden' name='date_dep' value='".$date_depart."'><input type='hidden' name='heure_mil1' value='".$heure_milieu1."'><input type='hidden' name='heure_mil2' value='".$heure_milieu2."'><input type='hidden' name='heure_arr' value='".$heure_arrivee."'><input type='hidden' name='classe' value='1'><input type='hidden' name='train1' value='".$train1."'><input type='hidden' name='train2' value='".$train2."'>";
   
        echo "<div class='reservation_historique_billet'>";
        date_default_timezone_set('Europe/Paris');
        $temps_billet=gmdate('H:i',strtotime($heure_arrivee)-strtotime($heure_depart));
        echo "<div class='historique_date_jour_billet'>";
        echo format_date_jour_billet($date_depart);
        echo "</div>";
        echo "<div class='historique_date_billet'>";
        echo format_date_billet($date_depart);
        echo "</div>";
        echo "<div class='reservation_heure_depart_billet'>";
        echo format_heure($heure_depart);
        echo "</div>";
        echo "<div class='reservation_depart_billet'>";
        echo $gare_depart;
        echo "</div>";
        echo "<div class='reservation_temps_billet'>".$temps_billet."</div>";
        echo "<div class='historique_heure_arrivee_billet'>".format_heure($heure_arrivee)."</div>";
        echo "<div class='reservation_arrivee_billet'>".$gare_arrivee."</div>";
        echo "<div class='chercher_historique_trajet'>";
        echo "<div class='historique_heure_depart'>";
        echo $heure_depart;
        echo "</div>";
        echo "<div class='reservation_gare_depart'>";
        echo $gare_depart;
        echo "</div>";
        echo "<div class='historique_heure_arrivee'>";
        echo $heure_milieu1;
        echo "</div>";
        echo "<div class='reservation_gare_arrivee'>";
        echo $gare_milieu;
        echo "</div>";
        echo "<img src='logo.png' class='reservation_logo_train'>";
        echo "<div class='reservation_train'>";
        echo $type_train1." n°".$train1;
        echo "</div>";
        echo "<div class='reservation_place'>";
        echo "place n° 132";
        echo "</div>";

        if($classe==1){
          echo "<select onchange='calculer_prix_billet()' class='reservation_select_classe_train' id='correspondance_classetrain1' name='classe1'>";
          echo "<option value='2'>2nd classe</option>";
          if($premiere_classe_dispo_train1)
            echo "<option selected value='1'>1ere classe</option>";
          echo "</select>";  
        }
        else{
          echo "<select onchange='calculer_prix_billet()' class='reservation_select_classe_train' id='correspondance_classetrain1' name='classe1'>";
          echo "<option selected value='2'>2nd classe</option>";
          if($premiere_classe_dispo_train1)
            echo "<option value='1'>1ere classe</option>";
          echo "</select>";
        }

        echo "</div>";
        echo "<div class='chercher_historique_trajet'>";
        echo "<div class='historique_heure_depart'>";
        echo $heure_milieu2;
        echo "</div>";
        echo "<div class='reservation_gare_depart'>";
        echo $gare_milieu;
        echo "</div>";
        echo "<div class='historique_heure_arrivee'>";
        echo $heure_arrivee;
        echo "</div>";
        echo "<div class='reservation_gare_arrivee'>";
        echo $gare_arrivee;
        echo "</div>";
        echo "<img src='logo.png' class='reservation_logo_train'>";
        echo "<div class='reservation_train'>";
        echo $type_train2." n°".$train2;
        echo "</div>";

        echo "<div class='reservation_place'>";
        echo "place n° 132";
        echo "</div>";

        if($classe==1){
          echo "<select onchange='calculer_prix_billet()' class='reservation_select_classe_train' id='correspondance_classetrain2' name='classe2'>";
          echo "<option value='2'>2nd classe</option>";
          if($premiere_classe_dispo_train2)
            echo "<option selected value='1'>1ere classe</option>";
          echo "</select>";
        }
        else{
          echo "<select onchange='calculer_prix_billet()' class='reservation_select_classe_train' id='correspondance_classetrain2' name='classe2'>";
          echo "<option selected value='2'>2nd classe</option>";
          if($premiere_classe_dispo_train2)
            echo "<option value='1'>1ere classe</option>";
          echo "</select>";
        }

        echo "</div>";
        echo "</div>";


// checkbox assurance
echo "<div class='reservation_box_assurance'>   
      <div class='reservation_assurance'>Assurance annulation pour ".$prix_assurance."€ de plus</div>
      <label class='container'>
      <input onchange='calculer_prix_billet()' type='checkbox' id='correspondance_assurance' name='assurance'>
      <span class='checkmark'></span>
      </label>
      </div>";



        echo "<div id='lieu_interet'>
      <div class='column'>";
    
      $lieu_interet="SELECT * from lieu_interet WHERE lieu_interet.fk_gare = (SELECT gare.id_gare FROM gare where gare.nom='".$gare_arrivee."')";
      $resultset= $connexion->prepare($lieu_interet);
      $resultset->execute();
      while ($row = $resultset->fetch(PDO::FETCH_ASSOC)){
        if($row['type_lieu']=='Logement'){
          echo "<div class='box'>";
          echo $row['nom_lt']."<br>adresse: ".$row['adresse_lt']."<br>";
          if($row['telephone_lt']!="") 
            echo "tel: ".$row['telephone_lt'];
          echo "</div>"; 
        }
      }
      echo "</div>


      <div class='column'>";
      $lieu_interet="SELECT * from lieu_interet WHERE lieu_interet.fk_gare = (SELECT gare.id_gare FROM gare where gare.nom='".$gare_arrivee."')";
      $resultset= $connexion->prepare($lieu_interet);
      $resultset->execute();
      while ($row = $resultset->fetch(PDO::FETCH_ASSOC)){
        if($row['type_lieu']=='Transport'){
          echo "<div class='box'>";
          echo $row['nom_lt']."<br>adresse: ".$row['adresse_lt']."<br>";
          if($row['telephone_lt']!="") 
            echo "tel: ".$row['telephone_lt'];
          echo "</div>"; 
        }
      }
      echo"</div></div>";


        echo "</div>";

        echo "<div class='reservation_partie_paiement'>";
        echo "<div class='reservation_box_paiement'>";
        
        echo "<div class='reservation_total'>Récapitulatif</div>";
        echo "<div class='reservation_total_billet'>Billet</div>";
        echo "<div id='correspondance_prix_total_billet' class='reservation_total_prix_billet'></div>";
        echo "<div class='reservation_total_assurance'>Assurance</div>";
        echo "<div id='correspondance_prix_assurance' class='reservation_total_prix_assurance'></div>";
        

     echo "<select class='reservation_paiement' name='paiement'>
        <option value='Chèque'>chèque</option> 
        <option value='Carte'>carte</option>
        <option value='Espèce'>espèce</option>
        </select><br><br>";

        echo "<div class='reservation_box_total'>
        <div class='reservation_box_titre_total'>Total</div>
        <div id='correspondance_prix_total_total' class='reservation_box_prix_total'></div>
        </div>";

        echo "<input type='submit' class='reservation_bouton_valider' value='VALIDER'>
        <a href='../index.php' class='reservation_bouton_annuler'>ANNULER</a>
        </form>";
        echo "</div>"; echo "</div>";
      }

      echo "</div>";
  

      
 
  $connexion=null;
  }
  ?>
</body>
</html>