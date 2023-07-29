	<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=hystiacraft', 'root', '');

	include_once('cookieconnect.php');
if(isset($_POST['formconnexion']))
{
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = strong_hash($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect))
   {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1)
      {
         if(isset($_POST['rememberme'])) {
            setcookie('email',$mailconnect,time()+365*24*3600,null,null,false,true);
            setcookie('password',$mdpconnect,time()+365*24*3600,null,null,false,true);
         }
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         $_SESSION['permission'] = $userinfo['permission'];
         header("Location: profil.php?id=".$_SESSION['id']);
      }
      else
      {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   }
   else
   {
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
      <title>Login</title>
      <meta charset="utf-8">
      		<link rel="stylesheet" href="style.css">
		<script async src="script.js"></script>
   </head>
   <body>
   	
   	<?php 
include "header.php";
?>
<article>
      <div align="center">
      	<div class="home-header">
         <h2>Connexion</h2>
         </div>
         <br /><br />
         
         <form class="home-form" method="post">
            <input type="email" name="mailconnect" placeholder="Mail" />
            <br /><br />
            <input type="password" name="mdpconnect" placeholder="Mot de passe" />
            <br /><br />
            <input type="checkbox" name="rememberme" id="remembercheckbox" /><label for="remembercheckbox">Se souvenir de moi</label>
            <br /><br />
            <input type="submit" name="formconnexion" value="Se connecter !" />
         </form>

         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
     </article>
      </div>
   </body>
</html>