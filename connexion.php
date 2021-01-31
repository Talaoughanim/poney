<?php
 session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// CREATE USER IF NOT EXISTS 'malik'@'localhost' IDENTIFIED BY 'nabila'; 
// GRANT ALL ON espace_membres.* TO 'malik'@'localhost';
 $bdd = new PDO('mysql:host=localhost;dbname=espace_membres','malik','nabila');
 $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
 if(isset($_POST['formconnexion'])) {
	$mailconnect = htmlspecialchars($_POST['mailconnect']);
	$mdpconnect = sha1($_POST['mdpconnect']);
	if(!empty($mailconnect) AND !empty($mdpconnect)) {
	   $requser = $bdd->prepare("SELECT * FROM Adherents WHERE mail = ? AND motdepasse = ?");
	   $requser->execute(array($mailconnect, $mdpconnect));
	   $userexist = $requser->rowCount();
	   if($userexist == 1) {
		  $userinfo = $requser->fetch();
		  $_SESSION['AdherentID'] = $userinfo['AdherentID'];
		  $_SESSION['pseudo'] = $userinfo['pseudo'];
		  $_SESSION['mail'] = $userinfo['mail'];
		  header("Location: profil.php?id=".$_SESSION['AdherentID']);

		  try { // on essaie d'executer la requete 
			$insertmbr = $bdd->prepare("INSERT INTO Adherents(mail, motdepasse) VALUES(?, ?)");
			$insertmbr->execute(array($mail, $mdp));
			$erreur = "Accès à votre compte ! <a href='profil.php.php'></a>";
		} catch (Exception $exception) { // si erreur : message d'erreur du prob rencontré 
			$erreur = $exception->getMessage();
		}


	   } else {
		  $erreur = "Mauvais mail ou mot de passe !";
	   }
	} else {
	   $erreur = "Tous les champs doivent être complétés !";
	}
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
    <header class = "header">
        <div id="logo">
        <img src="logo.jpg" alt="">
        </div>

        <div id ="title"> Le Poney Fringant</div>
    </header>

</section>

<section>
<div class="load">
  <hr/><hr/><hr/><hr/>
</div>
</section>
	   <div align="center">
		  <h2>Connexion</h2>
		  <br /><br />
		  <form method="POST" action="">
			 <input type="email" name="mailconnect" placeholder="Mail" />
			 <input type="password" name="mdpconnect" placeholder="Mot de passe" />
			 <br /><br />
			 <input type="submit" name="formconnexion" value="Se connecter !" />
		  </form>
		  <?php
		  if(isset($erreur)) {
			 echo '<font color="red">'.$erreur."</font>";
		  }
		  ?>
	   </div>
	</body>
 </html>