<?php 

require('../bdd.php');
require('../Config/config.php');
require('../Class/Helpers/Html.php');
require('../Class/Models/Candid.php');

$config = new Config();
$sUrl = $config->getSourceUrl();
$html = new Html($sUrl);
$model = new Candid($bdd);

if(!$model->isConnected()) {
	header('Location: ../login.php');
	die();
}

$candids = json_encode($model->find(['where' => ['request' => 'state=2', 'datas' => []]]));

 ?>

<html ng-app>
<head>
	<meta charset="UTF-8">
	<title>Admin</title>
	<?= $html->load('bootstrap'); ?>
</head>
<?php include 'Html/navbar.php' ?>
<body class="pager" ng-controller="CandidsController">

<div class="form-inline">
	<input class="form-control" type="text" ng-model="search.contact" placeholder="Skype ou mail"/>
	<input class="form-control" type="text" ng-model="search.age" placeholder="Age"/>
	<input class="form-control" type="text" ng-model="search.content" placeholder="Contenus"/>
	<input class="form-control" type="text" ng-model="search.dispo" placeholder="Dispos"/>
	<select name="required" class="form-control" ng-model="search.required">
		<option value="">Rien</option>
		<option value="Builder">Builder</option>
		<option value="Terraformeur">Terraformeur</option>
		<option value="Redstoneur">Redstoneur</option>
		<option value="Graphiste">Graphiste</option>
		<option value="Developpeur web">Developpeur web</option>
		<option value="Developpeur mod">Developpeur mod</option>
	</select>
</div>

<hr>
<h1>{{notData}}</h1>
<div ng-repeat="candid in candids | filter:search">
	<div class="well">
		<strong><p>{{candid.content}}</p></strong>
	</div>
	<h3>Disponibilités:</h3>
	
	<p>{{candid.dispo}}</p>
	<p>Envoyé par {{candid.contact}} qui a {{candid.age}} ans et postule pour devenir {{candid.required}}</p>
	<a href="state/default.php?id={{candid.id}}"><button class="btn btn-success">Désaccepter</button></a>
	<a href="state/refuse.php?id={{candid.id}}"><button class="btn btn-danger">Refuser</button></a>
	<a href="state/archive.php?id={{candid.id}}"><button class="btn btn-warning">Dépréaccepter</button></a>
	<hr>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.min.js"></script>

<script>
	function CandidsController($scope) {
		$scope.candids = <?= $candids ?>;
		$scope.notData = "";
		if($scope.candids.length == 0) {
			$scope.notData = "pas de candidatures pour l'instant";
		}
	}
</script>
</body>
</html>