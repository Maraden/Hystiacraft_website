<?php
session_start();
 
$bdd = new PDO('mysql:host=localhost;dbname=hystiacraft;charset=utf8', 'root', '');
   include_once('cookieconnect.php');
   include_once "parsedown.php";
include_once "parsedownextra.php";
   setlocale(LC_TIME, 'fr');
 $Parsedown = new Parsedown();
$Extra = new ParsedownExtra();
$Parsedown->setSafeMode(true);
$dtt = $bdd->query('SELECT * FROM membres ORDER BY date_inscription DESC');
$dtt = $dtt->fetch()['date_inscription'];

 
$var = ucfirst(strftime('%A, %d ',strtotime($dtt)));
$var .= ucfirst(strftime('%B %Y',strtotime($dtt)));
if(isset($_GET['id']) AND $_GET['id'] > 0) 
   $getid = intval($_GET['id']);
   $bdd->query('UPDATE membres SET certified = 0 ,avatar = "banni.png", Rank = 1 WHERE banni = 1');
   $bdd->query('UPDATE membres SET Rank = 2 ,derank_reason = "mauvais comportement" WHERE derank = 1');
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
   $reqrank = $bdd->prepare('SELECT * FROM rank WHERE id = ?');
   $reqrank->execute(array($userinfo["Rank"]));
   $rankinfo = $reqrank->fetch();
$msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ? ORDER BY Date_Time DESC ');

$msg->execute(array($_SESSION['id']));
$MpTotales = $msg->rowCount();

$MpParPage = 3;
$pagesTotales = ceil($MpTotales/$MpParPage);
if(isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page'] <= $pagesTotales) {
   $_GET['page'] = intval($_GET['page']);
   $pageCourante = $_GET['page'];
} else {
   $pageCourante = 1;
}
$depart = ($pageCourante-1)*$MpParPage;  


?>

<html>
   <head>
      <title>Profil de <?php echo $userinfo['pseudo']; ?></title>
      <meta charset="utf-8">
      <link rel="icon" href="membres/avatars/<?php echo $userinfo['avatar']; ?>">
      <link rel="stylesheet" href="style.css">
      <script async src="script.js"></script>
      <link rel="stylesheet" href="table.css">
   </head>
   <body>
<?php 
include "header.php";
?>

      <div align="center">
         <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
      </div>
         <article>  
         <form method="post" id="table">
            <table>
               <tr>
                  <?php
                  if(!empty($userinfo['avatar'])) {
                  ?>
                  <td rowspan="5">
                   <img src="membres/avatars/<?php echo $userinfo['avatar']; ?>" width="150">
                  </td>
                  <?php
                  }
                  ?> 
                  <td>Pseudo</td>
                  <td>=</td>
                  <td><?= $userinfo['pseudo'] ?> <?php if ($userinfo['certified'] == 1) { ?><img src="images/certified.png" width="15" onMouseOver="displayDivInfo('Certifié');" onMouseOut="displayDivInfo()" class="badge"><?php } ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td> <?php if ($userinfo['banni'] == 0) { ?><a href="envoi.php">Envoyer un message privé</a><?php } elseif ($userinfo['banni'] == 1) { ?><?php } ?></td>
               </tr>
               <tr>
                  <td>Mail</td>
                  <td>=</td>
                  <td><?= $userinfo['mail'] ?></td> 
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>           
               </tr>
               <tr>
                  <td>Grade</td>
                  <td>=</td>
                  <td><?php if ($userinfo['banni'] == 1) { ?>
                   Banni
                  <?php } else { ?>
                  <?= $rankinfo['name_role'] ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
               <?php } ?>
               </tr>
             <?php if ($userinfo['banni'] == 1) { ?>
               <tr>
                  <td class="td1">Sanction</td>
                  <td class="td1">=</td>
                  <td class="td1"><?= $userinfo['sanction'] ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <?php } else { ?>
               <tr>
                  <td >Date d'inscription</td>
                  <td >=</td>
                  <td ><?= $var ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
               <tr>
                  <td >Points:</td>
                  <td >=</td>
                  <td ><?= $userinfo['points'] ?></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
               </tr>
              <?php } ?>
               <tr>
                  <td><br>Badges</td>
               </tr>
               <tr>
                  <center>
                  <td><br>
                     <?php if ($userinfo['banni'] == 0){ ?>
                     <?php if ($userinfo['badge'] >= 0){ ?> 
                     <img src="badge/Membre.png" width="30" onMouseOver="displayDivInfo('Badge D`inscription');" onMouseOut="displayDivInfo()" class="badge">
                     <?php }  ?>
                    <?php if ($userinfo['Rank'] == 17 || $userinfo['Rank'] == 18){ ?>
                     <img src="badge/Admin.png" width="30" onMouseOver="displayDivInfo('Badge Administrateur<br> Badge donné au Administrateur');" onMouseOut="displayDivInfo()" class="badge">
                    <?php } ?>
                    <?php if ($userinfo['Rank'] == 15 || $userinfo['Rank'] == 16){ ?>
                     <img src="badge/Developpeur.png" width="30" onMouseOver="displayDivInfo('Badge Développeur(euse)<br> Badge donné au Développeur(euse)');" onMouseOut="displayDivInfo()" class="badge">
                    <?php } ?>
                     <?php if ($userinfo['Rank'] == 12 || $userinfo['Rank'] == 13){ ?>
                     <img src="badge/Responsable.png" width="30" onMouseOver="displayDivInfo('Badge Responsable<br> Badge donné au Responsable');" onMouseOut="displayDivInfo()" class="badge">
                    <?php } ?>
                     <?php if ($userinfo['Rank'] == 10 || $userinfo['Rank'] == 11){ ?>
                     <img src="badge/Modérateur.png" width="30" onMouseOver="displayDivInfo('Badge Modérateur<br> Badge donné au Modérateur');" onMouseOut="displayDivInfo()" class="badge">
                    <?php } ?>
                     <?php if ($userinfo['Rank'] == 6 || ($userinfo['Rank'] == 7)){ ?>
                     <img src=badge/Assistant.png" width="30" onMouseOver="displayDivInfo('Badge D`assistant<br> Badge donné au assistant');" onMouseOut="displayDivInfo()" class="badge">
                    <?php } ?>
                     <?php } ?> 
                  <?php if ($userinfo['Rank'] >= 8){ ?>
                  <img src="badge/Staff.png" width="30" onMouseOver="displayDivInfo('Membre du staff<br> Badge donné seulement au membre du staff');" onMouseOut="displayDivInfo()" class="badge">
                  <?php }?>
                  <?php if ($userinfo['Rank'] == 6){ ?>
                  <img src="badge/Staff.png" width="30" onMouseOver="displayDivInfo('Ancien membre du staff<br>Badge donné seulement au ancien membre du staff');" onMouseOut="displayDivInfo()" class="badge">
                  <?php } ?>
                  <?php if ($userinfo['derank'] == 1){ ?>
                  <img src="badge/banni.png" width="30" onMouseOver="displayDivInfo('derank du staff pour la raison: <?= $userinfo['derank_reason'] ?>');" onMouseOut="displayDivInfo()" class="badge">
                  <?php } ?>
                  </td>
               </center>
               </tr>
            </table>
         </form>
         <br>
         <br>
        <form>
          <table>
        <tr>
       <td rowspan="3">
         <?= $userinfo['bio'] ?>
       </td>
     </tr>
          </table>
        </form>
          <?php if (isset($_SESSION["id"])) { ?>
          
   <h3>Votre boîte de réception:</h3>
   <?php
$msg = $bdd->prepare('SELECT * FROM messages WHERE id_destinataire = ? ORDER BY Date_Time DESC LIMIT '.$depart.', '.$MpParPage);

$msg->execute(array($_SESSION['id']));
$msg_nbr = $msg->rowCount();
   if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }
   while($m = $msg->fetch()) {
      $p_exp = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
      $p_exp->execute(array($m['id_expediteur']));
      $p_exp = $p_exp->fetch();
      $p_exp = $p_exp['pseudo'];
      

   ?>
  <h1> <b><?= $p_exp ?></b> vous a envoyé le <?= nl2br($m['Date_Time']) ?>: <br /></h1>
  <h3> <?= nl2br($m['message']) ?><br /></h3>
 
   -------------------------------------<br/>

   <?php } ?>
    <?php } ?>
               <?php
      for($i=1;$i<=$pagesTotales;$i++) {
         if($i == $pageCourante) {
            echo $i.' ';
         } else {
            echo '<button><a href="profil.php?id='.$_SESSION['id'].'&page='.$i.'">'.$i.'</a></button> ';
         }
      }
      ?>
</article>
    </div>
   </body>
</html>
