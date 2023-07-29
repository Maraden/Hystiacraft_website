	<?php
   session_start();
$bdd = new PDO("mysql:host=127.0.0.1;dbname=hystiacraft;charset=utf8", "root", "");
   $mode_edition = 0;
if(isset($_GET['edit']) AND !empty($_GET['edit'])) {
   $mode_edition = 1;
   $edit_id = htmlspecialchars($_GET['edit']);
   $edit_article = $bdd->prepare('SELECT * FROM personnage WHERE id = ?');
   $edit_article->execute(array($edit_id));
   if($edit_article->rowCount() == 1) {
      $edit_article = $edit_article->fetch();
   } else {
      die('Erreur : l\'article n\'existe pas...');
   }
}
if(isset($_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['specialite'], $_POST['equip'], $_POST['inv'], $_POST['pouvoir'], $_POST['vaisseaux'], $_POST['faction'])) {
   if(!empty($_POST['nom']) AND !empty($_POST['prenom'] AND !empty($_POST['age']))) {
      
      $nom = htmlspecialchars($_POST['nom']);
      $prenom = htmlspecialchars($_POST['prenom']);
      $age = htmlspecialchars($_POST['age']);
      $specialite = htmlspecialchars($_POST['specialite']);
      $equip = htmlspecialchars($_POST['equip']);
      $inv = htmlspecialchars($_POST['inv']);
      $pouvoir = htmlspecialchars($_POST['pouvoir']);
      $vaisseaux = htmlspecialchars($_POST['vaisseaux']);
      $faction = htmlspecialchars($_POST['faction']);
      if($mode_edition == 0) {
         // var_dump($_FILES);
         // var_dump(exif_imagetype($_FILES['miniature']['tmp_name']));
         $ins = $bdd->prepare('INSERT INTO personnage (nom, prenom, age, specialite, equip, inv, pouvoir, vaisseaux, faction) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
         $ins->execute(array($nom, $prenom, $age, $specialite , $equip, $inv, $pouvoir, $vaisseaux, $faction));
         $lastid = $bdd->lastInsertId();


         $message = 'Votre article a bien été posté';
      } else {
         $update = $bdd->prepare('UPDATE personnage SET nom = ?, prenom = ? WHERE id = ?');
         $update->execute(array($nom, $prenom, $edit_id));
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
   <title>Création personnage</title>
   <meta charset="utf-8">
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <?php 
include "header.php";
?>
   <article>
   <form class="home-form" method="post" enctype="multipart/form-data">
      <input type="text" name="nom" placeholder="nom du personnage" /><br />
      <input type="text" name="prenom" placeholder="prenom du personnage" /><br />
      <input type="text" name="age" placeholder="age"><br />
      <input type="text" name="specialite" placeholder="Spécialité"><br />
      <input type="text" name="equip" placeholder="Equipement"><br />
      <input type="text" name="inv" placeholder="Taille de l'inventaire"><br />
      <input type="text" name="pouvoir" placeholder="Pouvoir"><br />
      <input type="text" name="vaisseaux" placeholder="Vaisseaux"><br />
      <input type="text" name="faction" placeholder="Faction"><br />
      <br>
      <input type="submit" name="Envoyer l'aricle">
   </form>
</article>
   <br />
   <?php if(isset($message)) { echo $message; } ?>
</body>
</html>