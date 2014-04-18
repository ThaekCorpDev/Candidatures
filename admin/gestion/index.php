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
	$find = $model->findByRank($_SESSION['user']->rank);
} else {
	$ranks = $model->findAll();
}

$message = "";
$error = true;

if(isset($_POST['content'])) {

	$edit = $model->edit($_SESSION['user']->rank);

	if(!$edit) {
		$message = "Veuillez remplir tout les champs";
		die();
	}

	$error = false;
	$message = "Les conditions on été modifiées";

}

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Gestion des candids'</title>
	<?= $html->load('bootstrap'); ?>
</head>
<body class="pager">
	
	<?php if ($error): ?>
		<div class="label label-danger"><?= $message ?></div>
	<?php else: ?>
		<div class="label label-success"><?= $message ?></div>
	<?php endif ?>
	
	<?php if ($_SESSION['user']->rank == "Admin"): ?>
		<?php foreach ($ranks as $k => $rank): ?>
			<a href="gestion.php?type=<?= $rank->rank; ?>">
				<button class="btn btn-success">
					<?= $rank->rank; ?>
				</button>
			</a>
		<?php endforeach ?>
	<?php else: ?>
		<form action="#" method="POST" class="form-inline">
			<textarea 
				name="content" 
				class="form-control" 
				placeholder="Conditions"
				required
			><?= $find->content ?>
			</textarea><br>
			<input type="submit" class="form-control btn btn-success">
		</form>
	<?php endif ?>
		
</body>
</html>