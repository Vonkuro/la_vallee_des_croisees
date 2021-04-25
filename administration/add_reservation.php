<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
ajout_reservation($_POST['client'], $_POST['chalet'], $_POST['semaine'], $_POST['date']);
header('location: ./admin.php?montre=reserv"')
// idiot proofing : interdire les reservations déjà existante pour même chalet et semaine
?>