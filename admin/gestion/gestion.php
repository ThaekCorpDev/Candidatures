<?php 

require('../../bdd.php');
require('../../Config/config.php');
require('../../Class/Helpers/Html.php');
require('../../Class/Models/Condition.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new Condition($bdd);

if(!$model->isConnected()) {
	header('Location: ../login.php');
	die();
}

if($_SESSION['user']->rank != "Admin") {
	header('Location: ./');
	die();
}

if(!isset($_GET['type'])) {
	die('Rank non touvé');
}

$find = $model->findByRank($_GET['type']);

if(!$find) {
	die('Rank non touvé');
}
$message = "";
$error = true;

if(isset($_POST['content'])) {

	$edit = $model->edit($_GET['type']);

	if(!$edit) {
		$message = "Veuillez remplir tout les champs";
		die();
	}

	$find = $model->findByRank($_GET['type']);

	$error = false;
	$message = "Les conditions ont été modifiées";
}


?>


<html>
<head>
	<meta charset="UTF-8">
	<title>Gestion - <?= $_GET['type']; ?></title>
	<?php echo $html->load('bootstrap'); ?>
</head>
<body class="pager">

	<?php if ($error): ?>
		<div class="label label-danger"><?= $message ?></div>
	<?php else: ?>
		<div class="label label-success"><?= $message ?></div>
	<?php endif ?>
	<form action="#" method="POST" class="form-inline">
		<textarea 
			name="content" 
			class="form-control" 
			placeholder="Conditions"
			required
		><?= $find->content ?></textarea><br><br>
		<input type="submit" class="form-control btn btn-success">
	</form>
</body>
</html>