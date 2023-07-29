<?php
$bdd = new PDO('mysql:host=localhost;dbname=hystiacraft;charset=utf8', 'root', '');
if(isset($_GET['id']) AND $_GET['id'] > 0) 
   $getid = intval($_GET['id']);
   $bdd->query('UPDATE membres SET Rank = "Banni" ,permission = 0, avatar = "banni.png", Rank = 1 WHERE banni = 1');
   $bdd->query('UPDATE membres SET Rank = "Membre" ,permission = 0, derank_reason = "mauvais comportement" WHERE derank = 1');
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
   $reqrank = $bdd->prepare('SELECT * FROM rank WHERE id = ?');
   $reqrank->execute(array($userinfo["Rank"]));
   $rankinfo = $reqrank->fetch();
   ?>