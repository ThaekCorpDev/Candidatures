<?php 

require('../../bdd.php');
require('../../Config/config.php');
require('../../Class/Helpers/Html.php');
require('../../Class/Models/User.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new User($bdd, $sUrl);

$message = "";

$saveOk = false;

if(isset($_POST['username'])) {
	$save = $model->addUser($_POST);
	if(!$save) {
		$message = "Veuillez remplir le champ";
		exit;
	}

	$saveOk = true;
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Ajouter un admin</title>
	<?= $html->load('bootstrap'); ?>
</head>
<body class="pager">

<?php if ($saveOk): ?>
	<h1>Mot de passe: <?= $save ?></h1>
<?php endif ?>
	<?= $message ?>
	<form action="#" method="post" class="form-inline">
		<input 
			type="text" 
			name="username"
			class="form-control" 
			placeholder="Nom d'utilisateur"
		/>
		<select name="rank" class="form-control">
			<option value="Builder">Builder/Terraformeur</option>
			<option value="Redstoneur">Redstoneur</option>
			<option value="Graphiste">Graphiste</option>
			<option value="Dev">Dev</option>
			<option value="Scenariste">Scenariste</option>
			<option value="Admin">Admin</option>
		</select>
		<input type="submit" value="Ajouter" class="btn btn-success">
	</form>
</body>
</html>