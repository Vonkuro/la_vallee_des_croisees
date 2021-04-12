<?php
require('fonctions.php');

#si tous les champs sont initialisés
if (isset($_POST['nom']) && !empty($_POST['nom'])) {
	$nom=$_POST['nom'];
} else {
	die("le nom est obligatoire");
}

if (isset($_POST['prenom']) && !empty($_POST['prenom'])) {
	$prenom=$_POST['prenom'];
} else {
	die("le prenom est obligatoire");
}

if (isset($_POST['date']) &&  !empty($_POST['date'])) {
	if (verifDate($_POST['date'])) {
		if (verifAge($_POST['date'])) {
			$date=$_POST['date'];
		} else {
			die("l'âge minimal pour s'inscrire est de 16 ans");
		}
	} else {
		die("la date n'est pas valide");
	}
} else {
	die("la date est obligatoire");
}

if (isset($_POST['mail']) && !empty($_POST['mail'])) {
	if (strlen($_POST['mail'])<=150 {
		if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
			if (!nonUniqueMail($_POST['mail'])) {
				$mail=$_POST['mail'];
			} else {
				die("ce mail est déjà utilisé");
			}
		} else {
			die("mauvais format du mail");
		}
	} else {
		die("le mail est trop grand, taille invalide");
	}
} else {
	die("le mail est obligatoire");
}

if (isset($_POST['telephone'])) {
	if (strlen($_POST['telephone'])<=50) {
		$telephone=$_POST['telephone'];
	} else {
		die("le telephone est trop grand, taille invalide");
	}
} else {
	die("telephone non initialisé");
}

if (isset($_POST['adresse'])) {
	$adresse=$_POST['adresse'];
} else {
	die("adresse non initialisé");
}

if (isset($_POST['cp']) && !empty($_POST['cp'])) {
	if (strlen($_POST['cp'])<=50) {
		$cp=$_POST['cp'];
	} else {
		die("le code postal est trop grand, taille invalide");
	}
} else {
	die("le code postal est obligatoire");
}

if (isset($_POST['mdp']) && !empty($_POST['mdp']) && isset($_POST['mdp2']) && !empty($_POST['mdp2'])) {
	if ($_POST['mdp']==$_POST['mdp2']) { 
		if (strlen($_POST['mdp'])<=30) {
			$mdp=$_POST['mdp'];
		} else {
			die("le mot de passe est trop grand, taille invalide");
		}
	} else {
		die("le mot de passe ne correspond pas au mot de passe retapé");
	}
} else {
	die("le mot de passe est obligatoire");
}

if (isset($_POST['ville']) && !empty($_POST['ville'])) {  
	if (strlen($_POST['ville'])<=58)) {
		$ville=$_POST['ville'];
	} else {
		die("la longueur du champ ville est trop grande, taille invalide");
	}
} else {
	die("la ville est obligatoire");
}

$message = ajoutClient($nom, $prenom, $date, $mail, $telephone, $adresse, $cp, $mdp, $ville);

?>

	<!-- PARTIE HTML -->
<html>

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


