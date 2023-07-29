<?php
include_once "global.php";
	include_once('cookieconnect.php');
$bdd = new PDO("mysql:host=127.0.0.1;dbname=hystiacraft;charset=utf8", "root", "");
$articles = $bdd->query('SELECT * FROM articles ORDER BY date_time_publication DESC');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Hystiacraft</title>
		<link rel="stylesheet" href="style.css">
      <meta charset="utf-8">
      <link rel="stylesheet" href="table.css">
		<script async src="script.js"></script>
	</head>
	<body>
<?php 
include "header.php";
?>
<article>
  <table border="1">
  <form method="post" id="table">
    <tr>
      <td><img src="badge/Admin.png" width="100"></td>
      <td>Badge donné au Administrateur</td>
      <td><img src="badge/Staff.png" width="100"></td>
      <td>Badge donné au membre du staff</td>
    </tr>
    <tr>
      <td><img src="badge/Responsable.png" width="100"></td>
      <td>Badge donné au Responsable <br><br> il gère les membres du staff</td>
      <td><img src="badge/studio.png" width="100"></td>
      <td>Badge des membres du projet "Hystiacraft Studio"</td>
    </tr>
    <tr>
      <td><img src="badge/Developpeur.png" width="100"></td>
      <td>Badge donné au Developpeur <br><br> il rajoute les fonctionnalités du site</td>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
    </tr>
    <tr>
      <td><img src="badge/Modérateur.png" width="100"></td>
      <td>Badge donné au Modérateur, il surveillent le forum</td>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
    </tr>
    <tr>
      <td><img src="badge/Assistant.png" width="100"></td>
      <td>Badge donné au Modérateur en test</td>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
    </tr>
    <tr>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
    </tr>
    <tr>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
      <td><img src="badge/default.png" width="100"></td>
      <td></td>
    </tr>
  </form>
</table>
 </article>


	</body>
</html>