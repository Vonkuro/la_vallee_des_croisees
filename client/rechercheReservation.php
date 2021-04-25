<?php
	session_start();
	require('./fonctions.php');
	echo $_SESSION['mail'];


#partie formulaire de recherche
?>
<form action="./rechercheReservation.php" method="GET">
	<label>DU : </label><br>
	<input type="date" name="date_debut" <?php if (isset($_GET['date_debut']))  { echo 'value="'.$_GET['date_debut'].'"' ;  }?> /></br>
	<label>AU :</label></br>
	<input type="date" name="date_fin" <?php if (isset($_GET['date_fin']))  { echo 'value="'.$_GET['date_fin'].'"' ;  }?>/></br>
	<label>Nombre de participants</label></br>
	<select name="nbre">
	<?php		
		for ($i=2 ; $i<7 ; $i++) {
			if (isset($_GET['nbre'])) {
				if ($_GET['nbre']==$i) {
					echo "<option value='$i' selected>$i personnes</option>";
				} else {
					echo "<option value='$i'>$i personnes</option>";
				}
			} else {
				echo "<option value='$i'>$i personnes</option>";
			}		
		}
	?>
	</select></br>
	<input type="submit" value="Rechercher"/>
</form>	


<?php
#partie recherche des chalets

#verification de la credibilité des champs
if (isset($_GET['nbre'])) {
	if (!empty($_GET['date_debut']) && !empty($_GET['date_fin'])) {
		if ($_GET['date_debut']<=$_GET['date_fin']) {
			$date_debut=$_GET['date_debut'];
			$date_fin=$_GET['date_fin'];
		} else {
			die('La date de début doit être avant la date de fin');
		}
	} else {
		die("L'une des dates est vide");
	}
	#requete sql pour récupérer les informations selon les critéres de la recherche
	$resultat=listChaletRech($date_debut, $date_fin, $_GET['nbre']);
	#affichage des resultats par blocs
	while ($donnees = $resultat->fetch()) {
	?>
		<div>
			DU : <?php echo $donnees['date_debut']; ?> <br>
			AU : <?php echo $donnees['date_fin']; ?> <br>
			Chalet : <?php echo $donnees['libelle']; ?> <br>
			Descriptif : <?php descriptionChalet($donnees['id_type_chalet']); ?><br>
			Prix : <?php echo prix_total($donnees['id_chalet']); ?> € <br>

			<?php etatChalet($_SESSION['mail'], $donnees["id_chalet"],$donnees['id_semaine']); ?>
			<form action="./rechercheReservation.php" method="POST">
				<input type="hidden" name="id" value="<?php echo $donnees["id_chalet"]; ?>"/>
				<input type="hidden" name="idS" value="<?php echo $donnees['id_semaine']; ?>"/>
				<input type="submit" value="Réserver ce chalet"/>
			</form>
		</div>
<?php
	}
}


#partie réservation d'un chalet
if (isset($_POST['id'])) {
	if (etatChalet($_SESSION['mail'],$_POST['id'],$_POST['idS'])) {
		ajoutReservation($_SESSION['mail'],$_POST['id'],$_POST['idS']);
	}
}

?>

