<?php

include_once "global.php";



if (!isset($_SESSION["id"])) {

	header("Location:login.php");

	exit();

	

}

?>

<!DOCTYPE html>

<html>

	<head>

		<title>Panel D'administration</title>

		<meta charset="utf-8">

		<link rel="stylesheet" href="style3.css">

		<link rel="stylesheet" href="right2.css">

	</head>

	<body>



		<center>

		Bienvenue

		<br>

		<br>

		<article id="right">

			<span id="video">

		<?php if ($_SESSION["id"] == 1){

				?>

			 	<a href="http://www.blocksandgold.com/fr/player/sheet/show/pseudo/Nitoblock">

			 <img src="https://Nitoxym.ml/images/N.png"></a>

		<?php }  elseif (($_SESSION["id"] == 2)) {

		 

			?>

				<a href="http://http://www.blocksandgold.com/fr/player/sheet/show/pseudo/alex77750">

			<img src="https://Maraden.ml/Maraden-Full.png" class="video"></a>

		<?php } ?>

		</span>

	</article>

		<br>

		<br>



<?php if ($_SESSION["id"] == 2 || $_SESSION["id"] == 1){

	?>

 <a href="" style="color:yellow"> Panel d'administration</a>

<?php } ?>

<br>

<br>



<?php if ($_SESSION["id"] == 2){

	?>

<article>

	<span id="video">

 		<a href="https://Maraden.ml">

 			<img src="https://Maraden.ml/Maraden-Full.png" class="video"></a>

 			<p style="color:#ff0000">Site principale de Maraden</p>

	</span>

	<span id="video">

		<a href="https://Alex77750.ml">

			<img src="A.PNG" class="video"></a>

			<p style="color:#ff0000">Ancien Site</p>

	</span>

</article>

<?php } ?>

<br>

<br>



<?php if ($_SESSION["id"] == 1 || $_SESSION["id"] == 2){

	?>

 <article>

 	<span id="video">

 		<a href="https://Nitoxym.ml">

 			<img src="https://www.nitoxym.ml/images/N.png" class="video"></a>

 			<p style="color:#00ccff">Site Principale de Nitoxym</p>

 		<br>

 		<a href="https://Nitocraft.fr">

 			<img src="NitoCraft.png" class="video"></a>

 			<p style="color:#00ccff">Site du serveur Nitocraft</p>

	</span>

</article>
<br>
<article>
	<p>Mise a jour de la page d'accueil</p>

	<p>Ajout des différentes case avec les spécialisation</p>
</article> 



<br>

<br>


<a href="logout.php" style="color:white">Déconnexion</a>

</center>
</body>
</html>