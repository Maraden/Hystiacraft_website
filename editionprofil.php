<?php
session_start();

   function strong_hash($str) {
   $str1 = hash("SHA512", $str);
   $str2 = intval($str1);
   $str3 = strlen($str2);
   $str4 = md5($str);

   return $str1 . $str2 . $str3 . $str4;
}

$bdd = new PDO('mysql:host=127.0.0.1;dbname=hystiacraft', 'root', '');
   include_once('cookieconnect.php');
   if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
 /*  if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   } */
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['bio']) AND !empty($_POST['bio']) AND $_POST['bio'] != $user['bio']) {
      $bio = htmlspecialchars($_POST['bio']);
      $insertbio = $bdd->prepare("UPDATE membres SET bio = ? WHERE id = ?");
      $insertbio->execute(array($bio, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);

   }
   if(isset($_POST['ytb']) AND !empty($_POST['ytb']) AND $_POST['ytb'] != $user['ytb']) {
      $ytb = htmlspecialchars($_POST['ytb']);
      $insertytb = $bdd->prepare("UPDATE membres SET ytb = ? WHERE id = ?");
      $insertytb->execute(array($ytb, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['facebook']) AND !empty($_POST['facebook']) AND $_POST['facebook'] != $user['facebook']) {
      $facebook = htmlspecialchars($_POST['facebook']);
      $insertfacebook = $bdd->prepare("UPDATE membres SET facebook = ? WHERE id = ?");
      $insertfacebook->execute(array($facebook, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['twitter']) AND !empty($_POST['twitter']) AND $_POST['twitter'] != $user['twitter']) {
      $twitter = htmlspecialchars($_POST['twitter']);
      $inserttwitter = $bdd->prepare("UPDATE membres SET twitter = ? WHERE id = ?");
      $inserttwitter->execute(array($twitter, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['spotify']) AND !empty($_POST['spotify']) AND $_POST['spotify'] != $user['spotify']) {
      $twitter = htmlspecialchars($_POST['spotify']);
      $insertspotify = $bdd->prepare("UPDATE membres SET spotify = ? WHERE id = ?");
      $insertspotify->execute(array($twitter, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = strong_hash($_POST['newmdp1']);
      $mdp2 = strong_hash($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: profil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }
   if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
   $tailleMax = 2097152;
   $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
   if($_FILES['avatar']['size'] <= $tailleMax) {
      $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
      if(in_array($extensionUpload, $extensionsValides)) {
         $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
         $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
         if($resultat) {
            $updateavatar = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
            $updateavatar->execute(array(
               'avatar' => $_SESSION['id'].".".$extensionUpload,
               'id' => $_SESSION['id']
               ));
            header('Location: profil.php?id='.$_SESSION['id']);
         } else {
            $msg = "Erreur durant l'importation de votre photo de profil";
         }
      } else {
         $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
      }
   } else {
      $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
   }
}



?>

<html>
   <head>
      <title>Edition profil</title>
      <meta charset="utf-8">
                  <link rel="stylesheet" href="style.css">
      <script async src="script.js"></script>
   </head>
   <body>
      <?php 
include "header.php";
?>

      <div align="center">
         <h2>Edition de mon profil</h2>
         <div align="left">
            <form class="home-form" method="post" enctype="multipart/form-data">
               <label>Pseudo :</label>
               <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
               <label>Mail :</label>
               <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /><br /><br />
               <label>Mot de passe :</label>
               <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br />
               <label>Confirmation - mot de passe :</label>
               <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
               <label>Avatar:</label>
               <input type="file" name="avatar" /> <br /><br />
               <textarea name="bio" placeholder="Biographie"></textarea> <br /><br />
               <input type="text" name="ytb" placeholder="https://youtube.com/"><br /><br />
               <input type="text" name="facebook" placeholder="https://facebook.com"><br /><br />
               <input type="text" name="twitter" placeholder="https://twitter.com"><br /><br />
               <input type="text" name="spotify" placeholder="https://spotify.com"><br /><br />
               <input type="submit" value="Mettre à jour mon profil !" />
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
         </div>
      </div>
   </body>
</html>
<?php   
}
else {
   header("Location: login.php");
}
?>