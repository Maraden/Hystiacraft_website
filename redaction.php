	<?php
   session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=hystiacraft;charset=utf8", "root", "");
   $mode_edition = 0;
if(isset($_GET['edit']) AND !empty($_GET['edit'])) {
   $mode_edition = 1;
   $edit_id = htmlspecialchars($_GET['edit']);
   $edit_article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
   $edit_article->execute(array($edit_id));
   if($edit_article->rowCount() == 1) {
      $edit_article = $edit_article->fetch();
   } else {
      die('Erreur : l\'article n\'existe pas...');
   }
}
if(isset($_POST['article_titre'], $_POST['article_contenu'], $_POST['auteur'])) {
   if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'] AND !empty($_POST['auteur']))) {
      
      $article_titre = htmlspecialchars($_POST['article_titre']);
      $article_contenu = htmlspecialchars($_POST['article_contenu']);
      $auteur = htmlspecialchars($_POST['auteur']);
      if($mode_edition == 0) {
         // var_dump($_FILES);
         // var_dump(exif_imagetype($_FILES['miniature']['tmp_name']));
         $ins = $bdd->prepare('INSERT INTO articles (titre, contenu, auteur, date_time_publication) VALUES (?, ?, ?, NOW())');
         $ins->execute(array($article_titre, $article_contenu, $auteur));
         $lastid = $bdd->lastInsertId();

            $extensionsValides = array('jpg', 'jpeg', 'png');
            if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['miniature']['name'], '.'), 1));
            if(in_array($extensionUpload, $extensionsValides)) {
               $chemin = 'miniatures/'.$lastid.'.png';
               move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
            } else {
               $message = 'Votre image doit être au format png';
            }
         }
         $message = 'Votre article a bien été posté';
      } else {
         $update = $bdd->prepare('UPDATE articles SET titre = ?, contenu = ?, date_time_edition = NOW() WHERE id = ?');
         $update->execute(array($article_titre, $article_contenu, $edit_id));
         header('Location: /');
         $message = 'Votre article a bien été mis à jour !';
      }
   } else {
      $message = 'Veuillez remplir tous les champs';
   }
}
?>
<!DOCTYPE html>
<html>
<head>
   <title>Rédaction / Edition</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <?php 
include "header.php";
?>
   <article>
   <form class="home-form" method="post" enctype="multipart/form-data">
      <input type="text" name="article_titre" placeholder="Titre" <?php if($mode_edition == 1) { ?> value="<?= $edit_article['titre'] ?>" <?php } ?> /><br />
      <textarea  name="article_contenu" placeholder="Contenu de l'article"><?php if($mode_edition == 1) { echo $edit_article['contenu']; } ?></textarea><br />
      <input type="text" name="auteur" placeholder="Votre Nom">
      <br>
      <?php if($mode_edition == 0) { ?>
      <input type="file" name="miniature" /><br />
      <?php } ?>
      <input type="submit" name="Envoyer l'aricle">
   </form>
</article>
   <br />
   <?php if(isset($message)) { echo $message; } ?>
</body>
</html>