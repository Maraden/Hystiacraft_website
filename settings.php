<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=hystiacraft', 'root', '');
if(isset($_GET['id']) AND $_GET['id'] > 0) 
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();

   


?>