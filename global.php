<?php
session_start();
session_regenerate_id();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=hystiacraft', 'root', '');
if (isset($_SESSION['id'])){
	$Query = $bdd->prepare("SELECT * FROM membres WHERE id=?");
	$Query->execute(array($_SESSION['id']));
	if ($Query->rowCount()) {
		$fetch = $Query->fetch();
		$rank = $fetch["Rank"]; 


	}
	   $reqrank = $bdd->prepare('SELECT * FROM rank WHERE id = ?');
   $reqrank->execute(array($fetch["Rank"]));
   $rankinfo = $reqrank->fetch();
}
function strong_hash($str) {
	$str1 = hash("SHA512", $str);
	$str2 = intval($str1);
	$str3 = strlen($str2);
	$str4 = md5($str);

	return $str1 . $str2 . $str3 . $str4;
}
?>