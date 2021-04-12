<?php
require('fonctions.php');

#si tous les champs sont initialisés
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date']) && isset($_POST['mail']) && isset($_POST['telephone']) && isset($_POST['adresse']) && isset($_POST['cp']) && isset($_POST['mdp']) && isset($_POST['mdp2']) && isset($_POST['ville'])) {
	#si tous les champs obligatoires contiennent une valeur
	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['date']) && !empty($_POST['mail']) && !empty($_POST['cp']) && !empty($_POST['mdp']) && !empty($_POST['mdp2']) && !empty($_POST['ville'])) {
		#si tous les mots de passe tapés sont les memes
		if ($_POST['mdp']==$_POST['mdp2']) {
			#bonne taille des String
			if (strlen($_POST['mail'])<=150 && strlen($_POST['telephone'])<=50 && strlen($_POST['cp'])<=50 && strlen($_POST['mdp'])<=30 && strlen($_POST['ville'])<=58) {
				#si la date est conforme
				if (verifDate($_POST['date'])) {
					#Verifie l'âge minimal
					if (verifAge($_POST['date'])) {
							#bon format du mail
						if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
							$message = ajoutClient($_POST['nom'],$_POST['prenom'],$_POST['date'],$_POST['mail'],$_POST['telephone'],$_POST['adresse'],$_POST['cp'],$_POST['mdp'],$_POST['ville']);
						} else {
							$message = "Mail invalide";
						}
					} else {
						$message = "Age erroné (16 ans minimum)";
					}
				} else {
					$message ="Date erronée";	
				}
			} else {
				$message = "Probleme de taille d'un des champs";
			}
		} else {
			$message = "Les deux mots de passe ne sont pas identiques";
		}
	} else {
		$message = "Un ou plusieurs champs obligatoires sont vides";
	}
}

?>
<html>
	<!-- PARTIE HTML -->
<head>
	
</head>
<body>
	<form action="./inscription.php" method="POST">
		<label>Nom</label><br>
		<input type="text" name="nom"><br><br>
		<label>Prenom</label><br>
		<input type="text" name="prenom"><br><br>
		<label>Date de naissance</label><br>
		<input type="date" name="date"><br><br>
		<label>Mail</label><br>
		<input type="text" name="mail"><br><br>
		<label>Téléphone</label><br>
		<input type="text" name="telephone"><br><br>
		<label>Adresse</label><br>
		<input type="text" name="adresse"><br><br>
		<label>Code Postal</label><br>
		<input type="text" name="cp"><br><br>
		<label>Ville</label><br>
		<input type="text" name="ville"><br><br>
		<label>Mot de passe</label><br>
		<input type="password" name="mdp"><br><br>
		<label>Retaper le mot de passe</label><br><br>
		<input type="password" name="mdp2"><br><br>
		<input type="submit" Value="S'inscrire">
	</form>
	<?php if (isset($message)) {
		echo $message;
	} ?>
</body>

</html>


