

<header>
			<div class="brand" draggable="true">
				<img src="../images/Hystiacraft_Full_Text_studio.png" class="header" draggable="false">
				<img src="../images/plugline-background.png" class="background" draggable="false">
			</div>
			<nav>
				<div class="selects">
					<div class="select accueil-select">Accueil
						<div class="dropdown accueil-dropdown">
						<a href="../index.php">Accueil</a>
					</div>
				</div>
                     
					<div class="select forum-select">Forum		
						<div class="dropdown forum-dropdown">
							<a href="">Forum</a>
						</div>
					</div>

					<div class="select cours-select">Projet
						<div class="dropdown cours-dropdown">
							<a href="workshop.php">Hystiacraft Workshop</a>
						</div>
					</div>

					<div class="select staff-select">Staff
					<div class="dropdown staff-dropdown">
						<a href="../staff.php">Liste du staff</a>
					    </div>
                     </div>
					<div class="select info-select">Info
					<div class="dropdown info-dropdown">
						<a href="partenaire.php">Partenaire</a>
						<br />
						<a href="Règlement.php">Règlement</a>
					</div>
					</div>

					<div class="select login-select">   
			          <?php if (isset($_SESSION["id"])) { ?>
                      Profil
                      <?php } else { ?>
                      Connexion
                      <?php } ?>
					<div class="dropdown login-dropdown">
                      <?php if (isset($_SESSION['id'])) {   ?> 
                  <br>
                      <a href="../profil.php?id=<?=$_SESSION['id']?>" >Profil</a>
                      <br>
                    <a href="../editionprofil.php">Editer mon profil</a>
                      <br>
                      <a href="../logout.php">Déconnexion</a>
                      <?php } else { ?>
                      <a href="../login.php">Connexion</a>
                      <br>
                      <a href="../inscription.php">Inscription</a>
                      <?php } ?>
					   </div>
				    </div>
				</div>
			</nav>
		</header>
