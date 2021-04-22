<?php
include '../ConnexionBDD.php';
include './fonction_sql.php';
modif_prix($_POST['id_chalet'], $_POST['id_semaine'],$_POST['prix']);
header('location: ./admin.php?montre=chalet&fait=modif&i='.$_POST['id_chalet'].'');

?>