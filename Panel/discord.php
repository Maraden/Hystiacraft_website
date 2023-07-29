<?php
$host = "localhost";
$dbname = "sanction";
$username = "root";
$password = "";
$table = "sanctions";

$limit = 50;



session_start();
session_regenerate_id();

if (!isset($_SESSION["page"])) $_SESSION["page"] = 0;
if (!isset($_SESSION["last"])) $_SESSION["last"] = "";

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

if (isset($_POST["save"])) {
	foreach ($_POST as $k => $v) {
		if ($k == "save") continue;

		$i = explode("-", $k)[1];
		$k = explode("-", $k)[0];

		if ($k == "id") continue;

		$q = $db->prepare("UPDATE $table SET " . htmlspecialchars("$k") . "=? WHERE id=?");
		$q->execute(array($v, $i));
	}

	header("Location:./" . (isset($_GET["search"]) ? "?search=" . $_GET["search"] : ""));
	exit;
}

$sql = "SELECT * FROM $table";

if (isset($_GET["search"])) {
	$_GET["search"] = preg_replace("/[^a-z0-9_%]/", "", strtolower($_GET["search"]));

	if ($_GET["search"] != $_SESSION["last"]) $_SESSION["page"] = 0;

	if (!$_GET["search"]) header("Location:./");
	
	$sql .= " WHERE username LIKE ?";
	$q = $db->prepare($sql . " ORDER BY id LIMIT " . $_SESSION["page"] * $limit . ", $limit");
	$q->execute(array($_GET["search"]));
} else {
	$q = $db->query($sql . " ORDER BY id LIMIT " . $_SESSION["page"] * $limit . ", $limit");
}

$data = array("id","sanction","reason","id_staff","id_user","username","username_staff");

if (isset($_POST["next"])) {
	$_SESSION["page"]++;
	header("Location:./" . (isset($_GET["search"]) ? "?search=" . $_GET["search"] : ""));
} else if (isset($_POST["prev"])) {
	$_SESSION["page"]--;
	if ($_SESSION["page"] < 0) $_SESSION["page"] = 0;
	header("Location:./" . (isset($_GET["search"]) ? "?search=" . $_GET["search"] : ""));
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Panel Hystiacraft</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<center>
		<h1>Panel Hystiacraft</h1>
		<div class="search">
			<form method="get">
				<input type="text" name="search" placeholder="Rechercher un pseudo"<?= isset($_GET["search"]) ? " value=\"" . $_GET["search"] . "\"" : "" ?>>
				<button>Rechercher</button>
				<div class="inside">
					<h2>
						&bull; Utiliser <i>valeur%</i> pour chercher un pseudo commençant par <i>valeur</i>
						<br>
						&bull; Utiliser <i>%valeur</i> pour chercher un pseudo finissant par <i>valeur</i>
						<br>
						&bull; Utiliser <i>%valeur%</i> pour chercher un pseudo contenant <i>valeur</i>
					</h2>
					<h3 class="value-button"><u>Valeurs affichées</u></h3>
					<a href="index.php"><h3>Panel site</h3></a>
					<div class="value-menu">
						<?php for ($i = 0; $i < sizeof($data); $i++) { ?><span class="value-menu-button button-<?= $data[$i] ?> display" value="<?= $data[$i] ?>"><?= $data[$i] ?></span><?php if ($i < sizeof($data) - 1) echo ", "; } ?>
						<br><br>
					</div>
				</div>
			</form>
		</div>
		<div class="table">
			<?php if ($q->rowCount()) { ?>
			<form method="post" id="table">
				<table>
					<thead>
						<tr>
							<?php for ($i = 0; $i < sizeof($data); $i++) { ?><th class="value-<?= $data[$i] ?>"><?= $data[$i] ?></th><?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php while ($f = $q->fetch()) { ?>
						<tr>
							<?php for ($i = 0; $i < sizeof($data); $i++) { ?><td class="<?= $i == 0 ? "" : "edit " ?>value-<?= $data[$i] ?> <?= $data[$i] . "-" . $f[0] ?>"><?= $f[$data[$i]] ?></td><?php } ?>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</form>
			<?php } else { ?>
			<h3>Aucun résultat</h3>
			<?php } ?>
		</div>
		<?php if ($q->rowCount() > 0) { ?>
		<div class="edited">
			<a href=""><button class="red">Annuler</button></a>
			<button form="table" class="green" name="save">Sauvegarder</button>
		</div>
		<div class="nav">
			<form method="post">
				<?php if ($_SESSION["page"])  { ?>
				<button name="prev">&lt;</button>
				<?php } ?>
				<button name="next">&gt;</button>
			</form>
		</div>
		<?php } ?>
		<script src="script.js"></script>
	</body>
</html>