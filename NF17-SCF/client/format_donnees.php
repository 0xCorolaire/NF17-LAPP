<?php
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
   ?>