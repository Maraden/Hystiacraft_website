	<?php
$bdd = new PDO('mysql:host=localhost;dbname=hystiacraft;charset=utf8', 'root', '');
 
if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = strong_hash($_POST['mdp']);
   $mdp2 = strong_hash($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse, date_inscription) VALUES(?, ?, ?, NOW())");
                     $insertmbr->execute(array($pseudo, $mail, $mdp));
                     $erreur = "Votre compte a bien été créé ! <a href=\"login.php\">Me connecter</a>";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
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
}
function strong_hash($str) {
   $str1 = hash("SHA512", $str);
   $str2 = intval($str1);
   $str3 = strlen($str2);
   $str4 = md5($str);

   return $str1 . $str2 . $str3 . $str4;
}
?>
   <html>
   <head>
      <title>Inscription</title>
      <meta charset="utf-8">
            <link rel="stylesheet" href="style.css">
      <script async src="script.js"></script>
   </head>
   <body>
            <?php 
include "header.php";
?>
      <div align="center">
  <article>
         <h2>Inscription</h2>

         <br /><br />
        <form class="home-form" method="post">
         
            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
            <br /><br />
           <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
            <br /><br />
           <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
            <br /><br />
             <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
             <br /><br />
            <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
            <br /><br />
            <input type="submit" name="forminscription" value="Je m'inscris" />
         </form>
           </article>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>