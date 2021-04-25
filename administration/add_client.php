<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
ajout_client($_POST['nom'], $_POST['prenom'], $_POST['date'], $_POST['mail'], $_POST['tel'], $_POST['adresse'], $_POST['cp'], $_POST['mdp'], $_POST['ville']);
header('location: ./admin.php?montre=client&fait=lire')

?>