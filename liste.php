<?php
include_once "global.php";
include_once "parsedown.php";
include_once "parsedownextra.php";
include_once "Converter.php";
include_once "Parsedown.php";
include_once "ParsedownExtra.php";
include_once "Parser.php";
require_once('footer.php');
	include_once('cookieconnect.php');
$bdd = new PDO("mysql:host=127.0.0.1;dbname=hystiacraft;charset=utf8", "root", "");
$articles = $bdd->query('SELECT * FROM personnage ');
$Parsedown = new Parsedown();
$Extra = new ParsedownExtra();
$Parsedown->setSafeMode(true);
$converter = new Markdownify\Converter;
   setlocale(LC_TIME, 'fr');

/*$dtt = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC');
$dtt = $dtt->fetch()['date_time_publication']; */

 
$var = ucfirst(strftime('%A, %d ',strtotime($dtt)));
$var .= ucfirst(strftime('%B %Y',strtotime($dtt)));
   $article = $bdd->query('SELECT * FROM personnage');
/*$converter->parseString */



?>
<!DOCTYPE html>
<html>
	<head>
		<title>Hystiacraft</title>
		<link rel="stylesheet" href="style.css">
		<script async src="script.js"></script>
	</head>
	<body>
<?php 
/*include "header.php"; */
?>
  <?php if($showcookie) { ?>
<div class="cookie-alert">
   En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de cookies pour vous proposer des contenus et services adaptés à vos centres d’intérêts.<br /><a href="accept_cookie.php">OK</a>
</div>
<?php } ?>
<article>
    <?php while($a = $articles->fetch()) {
      $id = $a['id'];
      $titre = $a['nom'];
      $contenu = $a['prenom'];
  
       ?>
      <br>
          <br>
            <h1>Nom : <?= $a['nom'] ?></h1>
            <h1>Prenom : <?= $a['prenom'] ?></h1>
            <h1>Age : <?= $a['age'] ?></h1>
            <h1>Spécialité : <?= $a['specialite'] ?></h1>
            <h1>Equipement : <?= $a['equip'] ?></h1>
            <h1>Inventaire : <?= $a['inv'] ?></h1>
            <h1>Pouvoir : <?= $a['pouvoir'] ?></h1>
            <h1>Vaisseaux : <?= $a['vaisseaux'] ?></h1>
            <h1>Faction : <?= $a['faction'] ?></h1>
             </article>
             <article>
            <center>
              <br>
                <br>



      <?php } ?>
 </article>
 <footer>
  <p>Hystiacraft © 2020 - <?php echo date('Y') ?> Licence <a href="https://creativecommons.org/licenses/by-nc/3.0/fr/" target="_blank">CC BY-NC 3.0</a> Tous droits réservés</p>
</footer>
	</body>
</html>