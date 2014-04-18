<?php 

include 'Michelf/Markdown.inc.php';

use \Michelf\Markdown;

$md = new Markdown;
$md->no_markup = false;

require('bdd.php');
require('Config/config.php');
require('Class/Helpers/Html.php');
require('Class/Models/Candid.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new Candid($bdd);

$errors = false;
$error = false;
$ok = false;




if(isset($_POST['contact'])) {
	$save = $model->save();

	if(!$save) {
		$error = true;
		$errors = $model->errors;
	} else {
		$ok = true;
		$error = true;
	}
}

?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Candidature TCorp</title>
	<?= $html->load('bootstrap'); ?>
</head>
<body>

<div class="pager">
	<?php if ($error): ?>
		<ul>
			<?php foreach ($model->errors as $k => $err): ?>
				<li><?= $err ?></li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>
	<?php if ($ok): ?>
		<h1>Tout va bien :D</h1>
	<?php endif ?>

	<form action="#" method="post" class="form-inline">
		<div class="form-group">
			<input 
				type="text" 
				class="form-control" 
				name="contact" 
				placeholder="Email ou skype"
				required
			/>
		</div><br><br>
		<div class="form-group">
			<input 
				type="text" 
				class="form-control" 
				name="age"	
				placeholder="age"
				required
			/>
		</div><br><br>
		<div class="form-group">
			<textarea
				class="form-control" 
				name="content" 
				placeholder="Présentation de vous"
				required
			></textarea>
		</div><br><br>
		<div class="form-group">
			<textarea
				class="form-control" 
				name="dispo" 
				placeholder="Vos disponibilités"
				maxlength="255"
				required
			></textarea>
		</div><br><br>
		<div class="form-group">
			<select name="required" class="form-control" id="rank">
				<option value="Builder">Builder</option>
				<option value="Terraformeur">Terraformeur</option>
				<option value="Redstoneur">Redstoneur</option>
				<option value="Graphiste">Graphiste</option>
				<option value="Developpeur mod">Developpeur mod</option>
				<option value="Developpeur web">Developpeur web</option>
				<option value="Scenariste">Scenariste</option>
			</select>
		</div><br><br>
		<div class="form-group">
			<input type="submit" class="form-control btn btn-success btn-lg">
		</div>
	</form>
	<div id="conditions" class="well">
		<h1>Pour acceder à ce rank il faut: </h1>
		<div id="cdt"><?php echo $model->findByRank('Builder')->content; ?></div>
	</div>
</div>

	<div class="panel well">©<a href="http://twitter.com/packofgaming">Coca</a> - 2014</div>

	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

	<script>

		lastRank = "Builder";

		var infos = {
			getInfos : function(r) {
				if(r == "Developpeur mod" || r == "Developpeur web") {
					return "<?= $model->findByRank('Dev', true)->content ?>";
				}
				if(r == "Builder" || r == "Terraformeur") {
					return "<?= $model->findByRank('Builder', true)->content ?>";
				}
				if(r == "Redstoneur") {
					return "<?= $model->findByRank('Redstonneur', true)->content ?>";
				}
				if(r == "Graphiste") {
					return "<?= $model->findByRank('Graphiste', true)->content ?>";
				}
				if(r == "Scenariste") {
					return "<?= $model->findByRank('Scenariste', true)->content ?>";
				}
				return "Pas de conditions";
			}
		};

		var info = Object.create(infos);
		rank = "";

		$('body').click(function(e){
			rank = "";
			if(lastRank != rank) {
				rank = $('#rank').val();
				$('#cdt').empty();
				$('#cdt').append(info.getInfos(rank));
				lastRank = rank;
			}
		});
	</script>
</body>
</html>