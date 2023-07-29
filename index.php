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
$articles = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC');
$Parsedown = new Parsedown();
$Extra = new ParsedownExtra();
$Parsedown->setSafeMode(true);
$converter = new Markdownify\Converter;
   setlocale(LC_TIME, 'fr');

$dtt = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC');
$dtt = $dtt->fetch()['date_time_publication'];

 
$var = ucfirst(strftime('%A, %d ',strtotime($dtt)));
$var .= ucfirst(strftime('%B %Y',strtotime($dtt)));
   $article = $bdd->query('SELECT * FROM articles');
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
include "header.php";
?>
  <?php if($showcookie) { ?>
<div class="cookie-alert">
   En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de cookies pour vous proposer des contenus et services adaptés à vos centres d’intérêts.<br /><a href="accept_cookie.php">OK</a>
</div>
<?php } ?>
<article>
    <?php while($a = $articles->fetch()) {
      $id = $a['id'];
      $titre = $a['titre'];
      $contenu = $a['contenu'];
      $likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
      $likes->execute(array($id));
      $likes = $likes->rowCount();
      $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
      $dislikes->execute(array($id));
      $dislikes = $dislikes->rowCount(); ?>
      <br>
          <br>
            <img src="miniatures/<?= $a['id'] ?>.png" width="200" /><br />
            <h1><?= $a['titre'] ?></h1>
            <br>
            <h3><?= $Parsedown->line($a["contenu"]) ?></h3> 
            <h6><?= $var ?></h6>
            <h6><?= $a['Auteur'] ?></h6>
            <center>
            <form>
              <table>
                <tr>
                  <td>
            <a href="action.php?t=1&id=<?= $id ?>"><img src="images/Pouce bleu.png" width="20"></a> (<?= $likes ?>)
          </td>
          <td>
            <a href="action.php?t=2&id=<?= $id ?>"><img src="images/Pouce rouge.png" width="20"></a> (<?= $dislikes ?>)
            </td>
          </tr>
        </table>
      </form>
    </center>
         <?php if (isset($fetch['Rank']) && $fetch['Rank'] >= 6) { ?>
          <br>
           <button><a href="redaction.php?edit=<?= $a['id'] ?>">Modifier</a></button> | <button><a href="supprimer.php?id=<?= $a['id'] ?>">Supprimer</a></button>


        <?php } ?>
      <?php } ?>
 </article>

	</body>
</html>