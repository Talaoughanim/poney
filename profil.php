<?php
 session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// CREATE USER IF NOT EXISTS 'malik'@'localhost' IDENTIFIED BY 'nabila'; 
// GRANT ALL ON espace_membres.* TO 'malik'@'localhost';
 $bdd = new PDO('mysql:host=localhost;dbname=espace_membres','malik','nabila');
 if(isset($_GET['id']) AND $_GET['id'] > 0) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM Adherents WHERE AdherentID = ?');
    $requser->execute(array($getid));
    $userinfo= $requser ->fetch(PDO::FETCH_ASSOC); // récupère les résultats
    
 ?>
 <html>
    <head>
    <section class="edition">
          <a href="editionprofil.php">Editer mon profil</a>
          <a href="deconnexion.php">Se déconnecter</a>
          </section>
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
          <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
          <br /><br />
          <?php 
          if(!empty($userinfo['avatar']))
          {
            ?> 
            <img src ="membres/avatars/<?php echo $userinfo['Photo']; ?>" width="150"/>
            <?php 
          }
          ?>
          <br /><br /> 
         Pseudo = <?php echo $userinfo['pseudo']; ?>
          <br />
          Mail = <?php echo $userinfo['mail']; ?>
          <br />
          <?php
          if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
          ?>
          <br />
          
          <?php
          }
          ?> 
       </div>
    </body>
 </html>
 <?php   
 }
 ?>