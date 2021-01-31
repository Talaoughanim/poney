<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// CREATE USER IF NOT EXISTS 'malik'@'localhost' IDENTIFIED BY 'nabila'; 
// GRANT ALL ON espace_membres.* TO 'malik'@'localhost';
$bdd = new PDO('mysql:host=localhost;dbname=espace_membres', 'malik', 'nabila');
if (isset($_SESSION['AdherentID'])) {

    $requser = $bdd->prepare("SELECT * FROM Adherents WHERE AdherentID=?");
    $requser->execute(array($_SESSION['AdherentID']));
    $userinfo = $requser->fetch();

    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) 
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']); // sécurisation de la variable nouvellement créée
        $insertpseudo = $bdd->prepare("UPDATE Adherents SET pseudo= ? WHERE AdherentID=? ");
        $insertpseudo-> execute(array($newpseudo, $_SESSION['AdherentID']));
        header('Location: profil.php?id='.$_SESSION['AdherentID']);
    }
    if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) 
    {
    
        $newmail = htmlspecialchars($_POST['newmail']); // sécurisation de la variable nouvellement créée
        $insertmail = $bdd->prepare("UPDATE Adherents SET mail= ? WHERE AdherentID=? ");
        $insertmail-> execute(array($newmail, $_SESSION['AdherentID']));
        header('Location: profil.php?id='.$_SESSION['AdherentID']);
    }

    if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1'])AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
    {
        $mdp1 =sha1($_POST['newmdp1']); //hashage du mot de passe
        $mdp2 =sha1($_POST['newmdp2']);
        
        if($mdp1 == $mdp2)
        {
            $insertmdp= $bdd->prepare("UPDATE Adherents SET motdepasse= ? WHERE AdherentIDs= ')");
            $insertmdp->execute(array($mdp1, $_SESSION['AdherentID']));
            header('Location: profil.php?id='.$_SESSION['AdherentID']);
        }
        else 
        {
            $msg = "Vos deux mot de passe ne correspondent pas !";
        }
    } 
   if(isset($_FILES['photo'])AND !empty($_FILES['photo']['name'])) // on vérifie si dans le fichier avatar s'il y a un nom qui correspond et existe
    {
        $tailleMax = 2097152; // octet
        $extensionsValides = array('jpg','jpeg','gif','png');
    if($_FILES['photo']['size'] <= $tailleMax) // vérifie la taille du fichier importé
    {
        $extensionUpload = strtolower(substr(strrchr($_FILES['photo']['name'], '.'), 1));
    // strtolower = Pour mettre les éléments de la chaine de caractère en minuscule
    // substr = ignorer un caractère de la chaine et donc va prendre uniquement l'extension
        if(in_array($extensionUpload, $extensionsValides))
        {
            $chemin = "membres/avatar".$_SESSION['AdherentID'].".".$extensionUpload;
            $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $_chemin); 
    // tmp_name = c'est le chemin temporaire du fichier
            if($resultat)
            {
                $updateavatar = $bdd->prepare('UPDATE Profils SET photo = :photo WHERE AdherentID = :id');
                //on execute la requête
                $updateavatar->execute(array(
                    'photo' => $_SESSION['AdherentID'].".".$extensionUpload, 
                    'AdherentID' => $_SESSION['AdherentID']
                ));
                header('Location: profil.php?id='.$_SESSION['AdherentID']);
            }
            else 
            {
                $msg = "Erreur durant l'importation de votre photo de profil";
            }
        }
        
        else{
            $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
        }
    }
    else 
    {
        $msg= "Votre photo de profil ne doit pas dépasser 2Mo";
    }
    }
    
  
?>
    <html>

    <head>
        <title>Poney Fringant</title>
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
            <h2>Edition de mon profil</h2>
            <div align="left">
                <form method="POST" action="" enctype="multipart/form-data"> <!-- entype = type d'encodage pour l'upload-->
                    <label> Pseudo :</label>
                    <input type="text" name="newpseudo" placeholder="pseudo" value="<?php echo $userinfo['pseudo']; ?>" /> <br /><br />
                    <label> Mail :</label>
                    <input type="text" name="newmail" placeholder="mail" value="<?php echo $userinfo['mail']; ?>" /> <br /><br />
                    <label> Mot de passe :</label>
                    <input type="password" name="newmdp1" placeholder="mot de passe" /> <br /><br />
                    <label> Confirmation - Mot de passe :</label>
                    <input type="password" name="newmdp2" placeholder="confirmation du mot de passe" /> <br /><br />
                    <label></label>
                    <input class="inout" type="file" name="avatar"/><br /><br />
                    <input class="inout" type="submit" value="Mettre à jour mon profil !"/> 
                </form>
                <?php if(isset($msg)) { echo $msg;} ?>

            </div>
        </div>

    </body>

    </html>
<?php
} else {
    header("Location: connexion.php");
}
?>