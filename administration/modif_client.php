<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
modif_client( $_POST['mail'], $_POST['nom'], $_POST['prenom'], $_POST['date'], $_POST['telephone'], $_POST['adresse'], $_POST['cp'], $_POST['mdp'], $_POST['ville']);
header('location: ./admin.php?montre=client&fait=lire')

?>