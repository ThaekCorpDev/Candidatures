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

if(isset($_POST['password'])) {
	$save = $model->changePw();
	if(!$save) {
		$message = "Erreur dans le formulaire";
		exit;
	}
	$message = "Mot de passe changer";
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Changer son mot de passe</title>
	<?= $html->load('bootstrap'); ?>
</head>
<body class="pager">
	<?= $message; ?>
	<form action="#" method="POST" class="form-inline">
		<input
			type="password" 
			class="form-control"
			name="lastPassword"
			placeholder="Ancien mot de passe"
			required
		/>
		<input
			type="password" 
			class="form-control"
			name="password"
			placeholder="Nouveau mot de passe"
			required
		/>
		<input
			type="password" 
			class="form-control"
			name="passConf"
			placeholder="Confirmation"
			required
		/>
		<input type="submit" class="form-control btn btn-success">
	</form>
</body>
</html>