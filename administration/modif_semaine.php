<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
modif_semaine($_POST['numero'], $_POST['date_d'],$_POST['date_f'] ,$_POST['annee'],$_POST['saison'],$_POST['id']);
header('location: ./admin.php?montre=semmaine&fait=lire')

?>