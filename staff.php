<?php

include_once "includes.php";
include_once "global.php";
    include_once('cookieconnect.php');

   $reqmembres = $bdd->query('SELECT * FROM membres WHERE rank >= 7 ORDER BY Rank DESC');
### Plus de variable membre, et on enlève la requête des rôles

      setlocale(LC_TIME, 'fr');



?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hystiacraft</title>
        <link rel="stylesheet" href="style.css">
        <script async src="script.js"></script>
            <link rel="stylesheet" href="table.css">
    </head>
    <body>
<?php 
include "header.php";
?>
<style>


.unevaleur {
  border-spacing: 50px 20px;
}

.deuxvaleurs {
  border-spacing: 5px 10px;
}


</style>
<article>
<center>
   <h1>Staff</h1>
         <form method="post" id="table">
            <table  class="unevaleur">
               <?php while($m = $reqmembres->fetch()) {
                 $reqrank = $bdd->prepare('SELECT * FROM rank WHERE id = ?');
                 $reqrank->execute(array($m["Rank"])); ### Ici c'est $m et pas $membres
                 $rankinfo = $reqrank->fetch();
                $dtt = $m['date_inscription'];

                $var = ucfirst(strftime('%A, %d ',strtotime($dtt)));
                $var .= ucfirst(strftime('%B %Y , %Hh %M',strtotime($dtt)));
              ?>

               <tr>
                  <td><img src="membres/avatars/<?php echo $m['avatar']; ?>" width="150"> <td><h1><?= $m['pseudo'] ?></h1></td>  <td><h2><?= $rankinfo['name_role'] ?></h2></td>  <td><h2><?= $var ?></td></h2>
               </tr>
               <?php } ?>

            </table>
         </form>
</center>
</article>
    </body>
</html>