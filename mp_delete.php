	<?php
$bdd = new PDO("mysql:host=127.0.0.1;dbname=hystiacraft;charset=utf8", "root", "");
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $suppr_id = htmlspecialchars($_GET['id']);
   $suppr = $bdd->prepare('DELETE FROM messages WHERE id = ?');
   $suppr->execute(array($suppr_id));
   header('Location: http://www.hyc.lc/hystiacraft/');
}
?>