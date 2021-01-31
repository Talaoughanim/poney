<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// CREATE USER IF NOT EXISTS 'malik'@'localhost' IDENTIFIED BY 'nabila'; 
// GRANT ALL ON espace_membres.* TO 'malik'@'localhost';
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'malik', 'nabila');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (isset($_POST['forminscription'])) {
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$mail = htmlspecialchars($_POST['mail']);
	$mail2 = htmlspecialchars($_POST['mail2']);
	$mdp = sha1($_POST['mdp']);
	$mdp2 = sha1($_POST['mdp2']);
	if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mail2']) and !empty($_POST['mdp']) and !empty($_POST['mdp2'])) {
		$pseudolength = strlen($pseudo);
		if ($pseudolength <= 255) {
			if ($mail == $mail2) {

				if ($mdp == $mdp2) {
					try { // on essaie d'executer la requete 
						$insertmbr = $bdd->prepare("INSERT INTO Adherents(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
						$insertmbr->execute(array($pseudo, $mail, $mdp));
						$erreur = "Votre compte a bien été créé ! <a href='connexion.php'>Me connecter</a>";
					} catch (Exception $exception) { // si erreur : message d'erreur du prob rencontré 
						$erreur = $exception->getMessage();
					}
				} else {
					$erreur = "Vos mots de passes ne correspondent pas !";
				}
			} else {
				$erreur = "Votre adresse mail n'est pas valide !";
			}
		} else {
			$erreur = "Vos adresses mail ne correspondent pas !";
		}
	} else {
		$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
	}
} else {
	$erreur = "Tous les champs doivent être complétés !";
}

?>

<html>

<head>
	<title>TUTO PHP</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<section>
		<header class="header">
			<div id="logo">
				<img src="logo.jpg" alt="">
			</div>

			<div id="title"> Le Poney Fringant</div>
		</header>

	</section>

	<section>
		<div class="load">
			<hr />
			<hr />
			<hr />
			<hr />
		</div>
	</section>
	<div align="center">
		<h2>Inscription</h2>
		<br /><br />
		<form method="POST" action="">
			<table>
				<tr>
					<td align="right">
						<label for="pseudo">Pseudo :</label>
					</td>
					<td>
						<input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if (isset($pseudo)) {
																											echo $pseudo;
																										} ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<label for="mail">Mail :</label>
					</td>
					<td>
						<input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if (isset($mail)) {
																										echo $mail;
																									} ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<label for="mail2">Confirmation du mail :</label>
					</td>
					<td>
						<input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if (isset($mail2)) {
																													echo $mail2;
																												} ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<label for="mdp">Mot de passe :</label>
					</td>
					<td>
						<input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
					</td>
				</tr>
				<tr>
					<td align="right">
						<label for="mdp2">Confirmation du mot de passe :</label>
					</td>
					<td>
						<input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="center">
						<br />
						<input type="submit" name="forminscription" value="Je m'inscris" />
					</td>
				</tr>
			</table>
		</form>
		<?php
		if (isset($erreur)) {
			echo '<font color="red">' . $erreur . "</font>";
		}
		?>
	</div>
</body>

</html>