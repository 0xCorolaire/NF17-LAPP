<?php
$user = 'nf17p050';
$password = 'klfRl2NH';

$connexion = new PDO('pgsql:host=tuxa.sme.utc ; dbname=dbnf17p050; port=5432',$user,$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
?>

