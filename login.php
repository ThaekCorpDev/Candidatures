<?php 

require('bdd.php');
require('Config/config.php');
require('Class/Helpers/Html.php');
require('Class/Models/User.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new User($bdd, $sUrl, false);
$message = "";

if(isset($_POST['username'])) {
	$login = $model->login();

	if(!$login) {
		$message = "Pseudo ou mot de passe incorrect";
	} else {
		header('Location: admin');
	}
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<?= $html->load('bootstrap'); ?>
</head>
<body class="pager">
	<div class="danger"><?= $message; ?></div>

	<form action="#" method="POST" class="form-inline">
		<input 
			type="text" 
			class="form-control"
			name="username"
			placeholder="Nom d'utilisateur"
			required
		/>
		<input 
			type="password"
			class="form-control"
			name="password"
			placeholder="Mot de passe"
			required
		/>
		<input
			type="submit" 
			value="Se connecter" 
			class="form-control btn btn-success"
		/>
	</form>
</body>
</html>