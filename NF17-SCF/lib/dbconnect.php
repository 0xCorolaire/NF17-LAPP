<?php
$user = 'root';
$password = '';
// $user = 'nf17p050';
// $password = 'klfRl2NH';

$connexion = new PDO('mysql:host=localhost;dbname=scf;charset=utf8', $user, $password);
$yes = 'https://vignette.wikia.nocookie.net/lecoeurasesraisons/images/9/9c/Coche-verte.png/revision/latest?cb=20130205125052&path-prefix=fr';
$no = 'https://www.auto-ecole.info/monsiteweb/images-defaut/galerie/coche-croix-style-4.png';
function formatDate($date)
{
  $t = explode("-", $date);
  return $t[2].'/'.$t[1].'/'.$t[0];
}?>
