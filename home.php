<?php
 
$bdd = new PDO('mysql:host=localhost;dbname=hystiacraft;charset=utf8', 'root', '');
	$stmt = $bdd->prepare('SELECT * FROM produits ORDER BY date_ajou DESC LIMIT 4');
	$stmt->execute();
	$recently_added_produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="produits.css">
	<title></title>
</head>
<body>
<?php 
include "header.php";
?>
	<div class="featured">
	    <h2>Téléphone</h2>
	    <p>Accessoires Téléphone</p>
	</div>
	<div class="recentlyadded content-wrapper">
	    <h2>Recently Added produits</h2>
	    <div class="produits" width="100%"><table style="margin: auto;"><tr>
	        <?php foreach ($recently_added_produits as $produit): ?>
	        <td><a href="index.php?page=produit&id=<?=$produit['id']?>" class="produit">            <img src="images/<?=$produit['img']?>" width="150" height="150" alt="<?=$produit['nom']?>"><br>
	            <span class="name"><?=$produit['nom']?></span><br>
	            <span class="price">
	                &dollar;<?=$produit['prix']?>
	                <?php if ($produit['prix_Réel'] > 0): ?>
	                <span class="prix_Réel">&euro;<?=$produit['prix_Réel']?></span>                <?php endif; ?>
	            </span>
	        </a></td>
	        <?php endforeach; ?>
	               </tr></table>
	    </div></div>
	


</body>
</html>